<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SoraCargo\Core\Models\SystemSetting;
use SoraCargo\Core\Models\Manifest;
use SoraCargo\Core\Models\EscrowLedger;
use SoraCargo\Core\Models\RevenueSplit;
use SoraCargo\Core\Models\CorporateCredit;
use SoraCargo\Core\Models\IncidentEscalation;
use SoraCargo\Core\Models\Port;
use SoraCargo\Core\Models\Route;
use SoraCargo\Core\Models\CargoBooking;

class AiServiceController extends Controller
{
    /**
     * Tampilkan Pengaturan Mesin AI & SoraBot Copilot.
     */
    public function index()
    {
        $settings = SystemSetting::where('group_name', 'ai_engine')->pluck('value', 'key');

        $modelName = $settings['ai_model_name'] ?? '';
        $systemPrompt = $settings['ai_system_prompt'] ?? 'Anda adalah SoraBot, AI Copilot operasional logistik maritim SoraCargo Indonesia...';
        $temperature = (float) ($settings['ai_temperature'] ?? 0.25);
        $maxTokens = (int) ($settings['ai_max_tokens'] ?? 4096);
        $usageTokens = (int) ($settings['ai_monthly_token_usage'] ?? 0);
        $quotaTokens = (int) ($settings['ai_monthly_token_quota'] ?? 2000000);

        // Model yang terdaftar murni manual dari input admin (tanpa template hardcode)
        $modelsSetting = SystemSetting::where('key', 'ai_available_models')->first();
        $availableModels = $modelsSetting ? json_decode($modelsSetting->value, true) : [];
        if (!is_array($availableModels)) {
            $availableModels = [];
        }

        return view('system.ai-service', compact(
            'modelName',
            'systemPrompt',
            'temperature',
            'maxTokens',
            'usageTokens',
            'quotaTokens',
            'availableModels'
        ));
    }

    /**
     * Simpan Konfigurasi Model AI & Kalibrasi Prompt SoraBot.
     */
    public function update(Request $request)
    {
        $request->validate([
            'ai_model_name' => 'nullable|string|max:150',
            'ai_temperature' => 'required|numeric|between:0,1',
            'ai_max_tokens' => 'required|integer|min:256|max:16384',
            'ai_system_prompt' => 'required|string|min:20|max:5000',
        ]);

        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        $now = now();

        SystemSetting::updateOrCreate(['key' => 'ai_model_name'], ['value' => (string) $request->ai_model_name, 'group_name' => 'ai_engine', 'updated_by' => $adminId, 'updated_at' => $now]);
        SystemSetting::updateOrCreate(['key' => 'ai_temperature'], ['value' => (string) $request->ai_temperature, 'group_name' => 'ai_engine', 'updated_by' => $adminId, 'updated_at' => $now]);
        SystemSetting::updateOrCreate(['key' => 'ai_max_tokens'], ['value' => (string) $request->ai_max_tokens, 'group_name' => 'ai_engine', 'updated_by' => $adminId, 'updated_at' => $now]);
        SystemSetting::updateOrCreate(['key' => 'ai_system_prompt'], ['value' => $request->ai_system_prompt, 'group_name' => 'ai_engine', 'updated_by' => $adminId, 'updated_at' => $now]);

        // Rekam Immutable Audit Trail
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'UPDATE_AI_ENGINE_SETTINGS',
            'target_schema' => 'admin',
            'target_table' => 'system_settings',
            'record_id' => 'ai_system_prompt',
            'before_state_json' => null,
            'after_state_json' => json_encode([
                'model' => $request->ai_model_name,
                'temperature' => $request->ai_temperature,
                'max_tokens' => $request->ai_max_tokens,
            ]),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => $now,
        ]);

        return redirect()->back()->with('success', "Konfigurasi Mesin AI SoraBot berhasil disimpan. Parameter model: {$request->ai_model_name} (Temp: {$request->ai_temperature}).");
    }

    /**
     * Tambah Model LLM Baru via Pop-up Modal (Manual Input oleh Admin).
     */
    public function storeModel(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'api_url' => 'required|url',
            'api_key' => 'required|string',
        ]);

        $modelsSetting = SystemSetting::where('key', 'ai_available_models')->first();
        $models = $modelsSetting ? json_decode($modelsSetting->value, true) : [];
        if (!is_array($models)) {
            $models = [];
        }

        $slugId = \Illuminate\Support\Str::slug($request->name);
        if (collect($models)->contains('id', $slugId)) {
            $slugId .= '-' . substr(uniqid(), -4);
        }

        $newModel = [
            'id' => $slugId,
            'name' => $request->name,
            'model_id' => $request->name,
            'url' => rtrim($request->api_url, '/'),
            'api_key' => $request->api_key,
            'created_at' => now()->toIso8601String(),
        ];

        $models[] = $newModel;

        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        SystemSetting::updateOrCreate(
            ['key' => 'ai_available_models'],
            ['value' => json_encode($models), 'group_name' => 'ai_engine', 'updated_by' => $adminId, 'updated_at' => now()]
        );

        // Otomatis jadikan model yang baru diinput sebagai model aktif
        SystemSetting::updateOrCreate(
            ['key' => 'ai_model_name'],
            ['value' => $newModel['id'], 'group_name' => 'ai_engine', 'updated_by' => $adminId, 'updated_at' => now()]
        );

        return response()->json([
            'success' => true,
            'model' => [
                'id' => $newModel['id'],
                'name' => $newModel['name'],
                'url' => $newModel['url'],
            ],
            'message' => "Model LLM '{$request->name}' berhasil ditambahkan secara manual."
        ]);
    }

    /**
     * Hapus Model LLM Tertentu oleh Admin.
     */
    public function deleteModel(Request $request)
    {
        $request->validate([
            'model_id' => 'required|string',
        ]);

        $modelId = $request->model_id;
        $modelsSetting = SystemSetting::where('key', 'ai_available_models')->first();
        $models = $modelsSetting ? json_decode($modelsSetting->value, true) : [];

        $updated = collect($models)->reject(function ($m) use ($modelId) {
            return ($m['id'] ?? '') === $modelId || ($m['name'] ?? '') === $modelId;
        })->values()->all();

        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        SystemSetting::updateOrCreate(
            ['key' => 'ai_available_models'],
            ['value' => json_encode($updated), 'group_name' => 'ai_engine', 'updated_by' => $adminId, 'updated_at' => now()]
        );

        // Jika model yang dihapus sedang aktif, ganti ke model lain atau kosongkan
        $activeSetting = SystemSetting::where('key', 'ai_model_name')->first();
        if ($activeSetting && ($activeSetting->value === $modelId || !collect($updated)->contains('id', $activeSetting->value))) {
            $nextModel = count($updated) > 0 ? $updated[0]['id'] : '';
            $activeSetting->value = $nextModel;
            $activeSetting->save();
        }

        return response()->json([
            'success' => true,
            'message' => "Model '{$modelId}' berhasil dihapus dari sistem."
        ]);
    }

    /**
     * Uji Koneksi / Ping Endpoint API Provider AI Secara Nyata (Live HTTP Request).
     */
    public function testConnection(Request $request)
    {
        $request->validate([
            'api_url' => 'required|url',
            'api_key' => 'required|string',
            'model_name' => 'nullable|string',
        ]);

        $url = rtrim($request->api_url, '/');
        $apiKey = $request->api_key;
        $startTime = microtime(true);

        try {
            $client = new \GuzzleHttp\Client(['timeout' => 8]);

            if (str_contains($url, '/v1') || !str_contains($url, 'googleapis.com')) {
                // Endpoint format OpenAI-compatible (9Router, Local LLM, v1)
                $endpoint = str_ends_with($url, '/v1') ? $url . '/models' : (str_contains($url, '/v1') ? $url : $url . '/v1/models');
                $response = $client->get($endpoint, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $apiKey,
                        'Accept' => 'application/json',
                    ]
                ]);
            } else {
                // Endpoint Google Gemini API
                $response = $client->get("{$url}/models?key={$apiKey}");
            }

            $latencyMs = round((microtime(true) - $startTime) * 1000);

            return response()->json([
                'success' => true,
                'latency_ms' => $latencyMs,
                'message' => "Koneksi berhasil terverifikasi! Endpoint merespons dalam {$latencyMs}ms (HTTP 200 OK). Request tercatat di gateway."
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : 400;
            return response()->json([
                'success' => false,
                'message' => "Autentikasi gagal (HTTP {$statusCode}): API Key atau URL ditolak oleh gateway."
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kesalahan saat menguji endpoint: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Uji Coba Simulasi Prompt Asisten AI Melalui API Model Terpilih (Live Call Tanpa Hardcode).
     */
    public function simulate(Request $request)
    {
        $request->validate([
            'test_query' => 'required|string|max:1000',
        ]);

        $query = $request->test_query;

        // 1. Ambil setting AI aktif
        $settings = SystemSetting::where('group_name', 'ai_engine')->pluck('value', 'key');
        $activeModelId = $settings['ai_model_name'] ?? '';
        $systemPrompt = $settings['ai_system_prompt'] ?? 'Anda adalah SoraBot, AI Copilot operasional logistik maritim SoraCargo Indonesia...';
        $temperature = (float) ($settings['ai_temperature'] ?? 0.25);
        $maxTokens = (int) ($settings['ai_max_tokens'] ?? 4096);

        // 2. Ambil spesifikasi model dari daftar model yang tersimpan manual
        $modelsSetting = SystemSetting::where('key', 'ai_available_models')->first();
        $availableModels = $modelsSetting ? json_decode($modelsSetting->value, true) : [];
        if (!is_array($availableModels) || empty($availableModels)) {
            $failMsg = 'Belum ada model AI yang dikonfigurasi. Silakan tambahkan model LLM secara manual terlebih dahulu melalui tombol (+) di pojok kanan atas.';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'query' => $query,
                    'response' => $failMsg,
                ], 422);
            }
            return redirect()->back()->with('test_result', $failMsg)->with('last_query', $query);
        }

        $activeModel = collect($availableModels)->first(function ($m) use ($activeModelId) {
            return ($m['id'] ?? '') === $activeModelId || ($m['name'] ?? '') === $activeModelId;
        }) ?? $availableModels[0];

        $apiUrl = $activeModel['url'] ?? '';
        $apiKey = $activeModel['api_key'] ?? '';
        $actualModelName = $activeModel['model_id'] ?? $activeModel['name'] ?? $activeModelId;

        if (empty($apiUrl) || empty($apiKey)) {
            $failMsg = "Model '{$actualModelName}' belum memiliki URL API atau API Key yang valid.";
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'query' => $query,
                    'response' => $failMsg,
                ], 422);
            }
            return redirect()->back()->with('test_result', $failMsg)->with('last_query', $query);
        }

        $client = new \GuzzleHttp\Client(['timeout' => 25]);

        // Ambil telemetri satelit cuaca maritim real-time (OpenWeatherMap + OpenCage) jika kueri terkait rute / cuaca
        $liveWeatherInfo = $this->resolveLiveWeatherContext($query);
        $effectiveSystemPrompt = $systemPrompt;
        if ($liveWeatherInfo) {
            $effectiveSystemPrompt .= "\n\n" . $liveWeatherInfo;
        }

        try {
            if (str_contains($apiUrl, '/v1') || !str_contains($apiUrl, 'googleapis.com')) {
                // Format OpenAI-compatible (9Router / v1 / LocalLLM)
                $endpoint = str_ends_with($apiUrl, '/chat/completions') 
                    ? $apiUrl 
                    : (str_ends_with($apiUrl, '/v1') ? $apiUrl . '/chat/completions' : rtrim($apiUrl, '/') . '/v1/chat/completions');

                $res = $client->post($endpoint, [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $apiKey,
                        'Accept' => 'application/json',
                    ],
                    'json' => [
                        'model' => $actualModelName,
                        'messages' => [
                            ['role' => 'system', 'content' => $effectiveSystemPrompt],
                            ['role' => 'user', 'content' => $query],
                        ],
                        'temperature' => $temperature,
                        'max_tokens' => $maxTokens,
                        'stream' => false,
                    ]
                ]);

                $body = json_decode($res->getBody(), true);
                $aiResponse = $body['choices'][0]['message']['content'] ?? 'Tidak ada teks yang dihasilkan dari model.';

                // Akumulasi konsumsi token
                if (isset($body['usage']['total_tokens'])) {
                    $used = (int) ($settings['ai_monthly_token_usage'] ?? 0) + $body['usage']['total_tokens'];
                    SystemSetting::updateOrCreate(['key' => 'ai_monthly_token_usage'], ['value' => (string) $used, 'group_name' => 'ai_engine']);
                }
            } else {
                // Google Gemini API Native
                $cleanModel = str_replace('models/', '', $actualModelName);
                $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$cleanModel}:generateContent?key={$apiKey}";
                $res = $client->post($endpoint, [
                    'json' => [
                        'systemInstruction' => [
                            'parts' => [['text' => $effectiveSystemPrompt]]
                        ],
                        'contents' => [
                            ['parts' => [['text' => $query]]]
                        ],
                        'generationConfig' => [
                            'temperature' => $temperature,
                            'maxOutputTokens' => $maxTokens,
                        ]
                    ]
                ]);

                $body = json_decode($res->getBody(), true);
                $aiResponse = $body['candidates'][0]['content']['parts'][0]['text'] ?? 'Tidak ada respons teks yang dihasilkan.';
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'query' => $query,
                    'response' => $aiResponse,
                    'model_used' => $actualModelName,
                ]);
            }

            return redirect()->back()->with('test_result', $aiResponse)->with('last_query', $query);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $errBody = $e->getResponse() ? (string) $e->getResponse()->getBody() : $e->getMessage();
            $errJson = json_decode($errBody, true);
            $msg = $errJson['error']['message'] ?? $errBody;
            $failMsg = "Error Gateway ({$e->getResponse()->getStatusCode()}): {$msg}";

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'query' => $query,
                    'response' => $failMsg,
                ], 422);
            }
            return redirect()->back()->with('test_result', $failMsg)->with('last_query', $query);

        } catch (\Throwable $e) {
            $failMsg = "Kesalahan menghubungi model '{$actualModelName}' ({$apiUrl}): " . $e->getMessage();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'query' => $query,
                    'response' => $failMsg,
                ], 500);
            }
            return redirect()->back()->with('test_result', $failMsg)->with('last_query', $query);
        }
    }

    /**
     * Endpoint API Chatbot Interaktif SoraBot AI Copilot (Context-Aware & Live Database Grounding).
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'page_path' => 'nullable|string|max:200',
            'page_title' => 'nullable|string|max:150',
            'active_tab' => 'nullable|string|max:50',
        ]);

        $userMessage = trim($request->message);
        $pagePath = $request->input('page_path', '/admin/dashboard');
        $pageTitle = $request->input('page_title', 'Dashboard Domestik');
        $activeTab = $request->input('active_tab', '');

        // 1. Ambil data operasional komprehensif dari database PostgreSQL SoraCargo secara dinamis (ZERO mock hardcode)
        // A. Pelabuhan & Depo Petikemas (Tabel public.ports & public.routes)
        $ports = Port::withCount(['originRoutes', 'destinationRoutes'])->get();
        $portsList = [];
        foreach ($ports as $p) {
            $totalRute = $p->origin_routes_count + $p->destination_routes_count;
            $portsList[] = "• {$p->name} ({$p->id}, {$p->city}) - Kapasitas CY: {$p->terminal_cy_capacity_teus} TEUs | Total Rute: {$totalRute} ({$p->origin_routes_count} rute asal, {$p->destination_routes_count} rute tujuan)";
        }
        $portsContext = implode("\n", $portsList);

        // B. Armada & Manifes (Tabel public.manifests)
        $activeManifests = Manifest::whereIn('status', ['SAILING', 'WEATHER_HOLD', 'LOADING'])->get();
        $sailingCount = $activeManifests->where('status', 'SAILING')->count();
        $weatherHoldCount = $activeManifests->where('status', 'WEATHER_HOLD')->count();
        $manifestsList = [];
        foreach ($activeManifests as $m) {
            $manifestsList[] = "• {$m->vessel_or_vehicle_name} ({$m->manifest_number}) | Status: {$m->status} | Rute: {$m->origin_port_id} -> {$m->destination_port_id} | ETA: " . ($m->arrival_eta ? $m->arrival_eta->format('d M H:i') : '-');
        }
        $manifestsContext = implode("\n", $manifestsList);

        // C. Keuangan & Escrow (Tabel public.escrow_ledgers, public.revenue_splits, public.corporate_credits)
        $escrowHeld = EscrowLedger::whereIn('escrow_status', ['HELD_IN_ESCROW', 'PARTIALLY_RELEASED', 'DISPUTE_FROZEN'])->sum('total_paid_amount') ?? 0;
        $platformProfit = RevenueSplit::sum('net_platform_profit') ?? 0;
        $overdueClients = CorporateCredit::with('company')
            ->whereIn('debt_enforcement_stage', ['SP1_ISSUED', 'SP2_LOCKED', 'SP3_LEGAL_COLLECTION'])
            ->get();
        $overdueList = [];
        foreach ($overdueClients as $oc) {
            $companyName = $oc->company->company_name ?? 'Mitra B2B';
            $overdueList[] = "• {$companyName} | Status: {$oc->debt_enforcement_stage} | Plafon: Rp " . number_format($oc->credit_limit_amount, 0, ',', '.') . " | Terpakai: Rp " . number_format($oc->used_credit_amount, 0, ',', '.');
        }
        $overdueContext = implode("\n", $overdueList);

        // D. Kedaruratan & Tiket Eskalasi (Tabel public.incident_escalations)
        $criticalEscalations = IncidentEscalation::where('approval_status', 'PENDING_REVIEW')->count();

        // E. Pesanan & Bookings (Tabel ops.cargo_bookings)
        $totalBookings = CargoBooking::count();
        $pendingBookings = CargoBooking::whereIn('cargo_status', ['GATE_IN', 'CUSTOMS_INSPECTION', 'WEATHER_HOLD'])->count();

        // 2. Ambil konfigurasi model aktif & kalibrasi setting AI
        $settings = SystemSetting::where('group_name', 'ai_engine')->pluck('value', 'key');
        $activeModelId = $settings['ai_model_name'] ?? '';
        $customSystemPrompt = $settings['ai_system_prompt'] ?? 'Anda adalah SoraBot, AI Copilot operasional logistik maritim SoraCargo Indonesia...';
        $temperature = (float) ($settings['ai_temperature'] ?? 0.25);
        $maxTokens = (int) ($settings['ai_max_tokens'] ?? 4096);
        $modelsSetting = SystemSetting::where('key', 'ai_available_models')->first();
        $availableModels = $modelsSetting ? json_decode($modelsSetting->value, true) : [];

        if (!is_array($availableModels) || empty($availableModels)) {
            return response()->json([
                'success' => false,
                'reply' => 'Layanan SoraBot AI memerlukan model LLM aktif. Saat ini belum ada model AI yang dikonfigurasi secara manual oleh Superadmin. Silakan buka menu Sistem > Pengaturan Mesin AI untuk menambahkan model.',
                'timestamp' => now()->format('H:i')
            ], 422);
        }

        $activeModel = collect($availableModels)->first(function ($m) use ($activeModelId) {
            return ($m['id'] ?? '') === $activeModelId || ($m['name'] ?? '') === $activeModelId;
        }) ?? $availableModels[0];

        $apiUrl = $activeModel['url'] ?? '';
        $apiKey = $activeModel['api_key'] ?? '';
        $actualModelName = $activeModel['model_id'] ?? $activeModel['name'] ?? $activeModelId;

        if (empty($apiUrl) || empty($apiKey)) {
            return response()->json([
                'success' => false,
                'reply' => "Model '{$actualModelName}' belum memiliki URL API atau API Key yang valid. Silakan periksa konfigurasi di menu Sistem > Pengaturan Mesin AI.",
                'timestamp' => now()->format('H:i')
            ], 422);
        }

        try {
            // Ambil telemetri satelit cuaca jika kueri pengguna terkait rute / cuaca
            $liveWeatherInfo = $this->resolveLiveWeatherContext($userMessage);

            $systemInstruction = ($customSystemPrompt ? "Instruksi Khusus Superadmin:\n{$customSystemPrompt}\n\n" : "")
                . "Anda adalah SoraBot, AI Copilot operasional logistik maritim SoraCargo Superadmin.\n\n"
                . "=== LOKASI & HALAMAN AKTIF ADMIN SAAT INI ===\n"
                . "Halaman yang sedang dibuka Admin: {$pageTitle} (Path: {$pagePath})\n"
                . ($activeTab ? "Mode / Tampilan Tab Aktif: {$activeTab}\n\n" : "\n")
                . "=== PEDOMAN RESPON KONTEKSTUAL (PAGE-AWARE & GROUNDED) ===\n"
                . "1. FOKUS HALAMAN AKTIF:\n"
                . "   Jika admin bertanya ringkasan umum (misalnya: \"apa ringkasan hari ini\", \"bagaimana kondisinya\", \"apa status sekarang\"), berikan jawaban yang BERFOKUS PENUH pada data dan metrik dari modul/halaman yang sedang dibuka ({$pageTitle}).\n"
                . "2. PERTANYAAN LINTAS MODUL / HALAMAN LAIN:\n"
                . "   Jika admin bertanya mengenai data dari halaman atau tabel lain (misal sedang di Dashboard tapi bertanya: \"berapa total pelabuhan yang memiliki 2 rute\" atau \"berapa saldo escrow\"), sebutkan sumber modul atau tabelnya secara eksplisit dengan format:\n"
                . "   \"Menurut data tabel [Nama Tabel / Halaman], [jawaban fakta angka akurat]...\"\n"
                . "   Contoh: \"Menurut data tabel Daftar Pelabuhan, Terminal & Depo Penumpukan dari halaman Pelabuhan & Depo Petikemas (Tabel public.ports & public.routes), total pelabuhan yang memiliki 2 rute sebanyak 3 pelabuhan: Pelabuhan Tanjung Priok, Tanjung Perak, dan Batu Ampar.\"\n"
                . "3. INTEGRITAS DATA:\n"
                . "   Semua data di bawah ini diambil murni dari database PostgreSQL SoraCargo secara real-time. Jangan membuat angka fiktif atau data karangan.\n\n"
                . "=== DATA REAL-TIME DATABASE SORACARGO TERKINI ===\n"
                . "[Modul Pelabuhan & Depo Petikemas - public.ports & public.routes]\n"
                . "Total Pelabuhan: " . count($ports) . " pelabuhan\n"
                . $portsContext . "\n\n"
                . "[Modul Armada & Manifes - public.manifests]\n"
                . "Total Armada Aktif: " . $activeManifests->count() . " armada ({$sailingCount} berlayar, {$weatherHoldCount} tertahan cuaca BMKG)\n"
                . $manifestsContext . "\n\n"
                . "[Modul Keuangan & Escrow - public.escrow_ledgers & public.corporate_credits]\n"
                . "- Total Dana Terkunci di Rekening Escrow: Rp " . number_format($escrowHeld, 0, ',', '.') . "\n"
                . "- Margin Platform Bulan Ini: Rp " . number_format($platformProfit, 0, ',', '.') . "\n"
                . "- Total Mitra Korporat Overdue: " . count($overdueClients) . " mitra\n"
                . ($overdueContext ? $overdueContext . "\n" : "") . "\n"
                . "[Modul Kedaruratan & Tiket - public.incident_escalations]\n"
                . "- Tiket Eskalasi Darurat Butuh Disposisi: {$criticalEscalations} kasus\n\n"
                . "[Modul Bookings & Pesanan - public.cargo_bookings]\n"
                . "- Total Pesanan Terdaftar: {$totalBookings} pesanan\n"
                . "- Pesanan Menunggu Pembayaran/Verifikasi: {$pendingBookings} pesanan\n\n";

            if ($liveWeatherInfo) {
                $systemInstruction .= $liveWeatherInfo . "\n\n";
            }

            $systemInstruction .= "Berikan jawaban profesional, akurat, informatif, dan ringkas dalam Bahasa Indonesia.";

            $client = new \GuzzleHttp\Client(['timeout' => 25]);

            if (str_contains($apiUrl, '/v1') || !str_contains($apiUrl, 'googleapis.com')) {
                $endpoint = str_ends_with($apiUrl, '/chat/completions') 
                    ? $apiUrl 
                    : (str_ends_with($apiUrl, '/v1') ? $apiUrl . '/chat/completions' : rtrim($apiUrl, '/') . '/v1/chat/completions');

                $res = $client->post($endpoint, [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $apiKey,
                        'Accept' => 'application/json',
                    ],
                    'json' => [
                        'model' => $actualModelName,
                        'messages' => [
                            ['role' => 'system', 'content' => $systemInstruction],
                            ['role' => 'user', 'content' => $userMessage],
                        ],
                        'temperature' => $temperature,
                        'max_tokens' => $maxTokens,
                        'stream' => false,
                    ]
                ]);

                $body = json_decode($res->getBody(), true);
                $reply = $body['choices'][0]['message']['content'] ?? 'Tidak ada respons teks yang dihasilkan dari model.';

                // Akumulasi konsumsi token bulanan di sesi Chatbot
                if (isset($body['usage']['total_tokens'])) {
                    $used = (int) ($settings['ai_monthly_token_usage'] ?? 0) + $body['usage']['total_tokens'];
                    SystemSetting::updateOrCreate(['key' => 'ai_monthly_token_usage'], ['value' => (string) $used, 'group_name' => 'ai_engine']);
                }
            } else {
                $cleanModel = str_replace('models/', '', $actualModelName);
                $res = $client->post("https://generativelanguage.googleapis.com/v1beta/models/{$cleanModel}:generateContent?key={$apiKey}", [
                    'json' => [
                        'systemInstruction' => [
                            'parts' => [['text' => $systemInstruction]]
                        ],
                        'contents' => [
                            ['parts' => [['text' => $userMessage]]]
                        ],
                        'generationConfig' => [
                            'temperature' => $temperature,
                            'maxOutputTokens' => $maxTokens,
                        ]
                    ]
                ]);
                $body = json_decode($res->getBody(), true);
                $reply = $body['candidates'][0]['content']['parts'][0]['text'] ?? 'Tidak ada respons teks yang dihasilkan dari model.';
            }

            return response()->json([
                'success' => true,
                'reply' => $reply,
                'timestamp' => now()->format('H:i')
            ]);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $errBody = $e->getResponse() ? (string) $e->getResponse()->getBody() : $e->getMessage();
            $errJson = json_decode($errBody, true);
            $msg = $errJson['error']['message'] ?? $errBody;
            return response()->json([
                'success' => false,
                'reply' => "Gagal terhubung ke model AI '{$actualModelName}' ({$apiUrl}) [HTTP {$e->getResponse()->getStatusCode()}]: {$msg}",
                'timestamp' => now()->format('H:i')
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'reply' => "Kesalahan menghubungi gateway model AI '{$actualModelName}': " . $e->getMessage(),
                'timestamp' => now()->format('H:i')
            ], 500);
        }
    }

    /**
     * Ambil data satelit cuaca maritim real-time global (OpenWeatherMap + OpenCage Geocoding).
     * Mendukung deteksi lokasi rute maritim lokal nusantara maupun pelabuhan internasional seluruh dunia.
     */
    private function resolveLiveWeatherContext(string $query): ?string
    {
        $lower = strtolower($query);
        $weatherKeywords = [
            'cuaca', 'ombak', 'angin', 'badai', 'hujan', 'gelombang', 
            'suhu', 'weather', 'selat', 'perairan', 'laut', 'rute', 
            'berlayar', 'pelayaran', 'maritim', 'ekstrem', 'extream', 'bmkg', 'pelabuhan'
        ];

        $hasKeyword = false;
        foreach ($weatherKeywords as $kw) {
            if (str_contains($lower, $kw)) {
                $hasKeyword = true;
                break;
            }
        }

        if (!$hasKeyword) {
            return null;
        }

        $openWeatherKey = config('services.openweather.key') ?: env('OPENWEATHER_API_KEY');
        $geoKey = config('services.opencage.key') ?: env('GEOCODING_API_KEY');

        $client = new \GuzzleHttp\Client(['timeout' => 4]);

        // Coba ekstrak kandidat nama lokasi dari kueri admin
        $stopWords = [
            'bagaimana', 'kondisi', 'cuaca', 'di', 'saat', 'ini', 'apakah', 'sekarang', 
            'hari', 'tolong', 'cek', 'pantau', 'rute', 'pelayaran', 'kapal', 'ombak', 
            'angin', 'badai', 'hujan', 'gelombang', 'suhu', 'sedang', 'mengalami', 
            'ekstrem', 'extream', 'kencang', 'tinggi', 'aman', 'berlayar', 'laut', 
            'perairan', 'apa', 'yang', 'portal', 'data', 'terkini', 'info', 'tentang',
            'kota', 'kabupaten', 'provinsi', 'negara', 'wilayah', 'daerah', 'kecamatan', 'kelurahan',
            'pagi', 'siang', 'sore', 'malam', 'subuh', 'besok', 'lusa', 'kemarin', 'dini'
        ];
        $quoted = array_map('preg_quote', $stopWords);
        $pattern = '/\b(' . implode('|', $quoted) . ')\b|[?.,!]/i';
        $locationCandidate = trim(preg_replace('/\s+/', ' ', preg_replace($pattern, ' ', $query)));

        $directions = ['Utara', 'Timur Laut', 'Timur', 'Tenggara', 'Selatan', 'Barat Daya', 'Barat', 'Barat Laut'];

        // Skenario 1: Lokasi spesifik terdeteksi (misal "lhokseumawe", "selat sunda", "rotterdam", "shanghai", "tanjung priok", dll)
        if (!empty($locationCandidate) && strlen($locationCandidate) >= 3) {
            try {
                $loc = null;

                // 1. Coba OpenCage dengan kandidat nama lokasi lengkap
                $geoRes = $client->get('https://api.opencagedata.com/geocode/v1/json', [
                    'query' => [
                        'q' => $locationCandidate,
                        'key' => $geoKey,
                        'limit' => 1
                    ]
                ]);
                $geoData = json_decode($geoRes->getBody(), true);
                $firstCandidateResult = $geoData['results'][0] ?? null;

                // Validasi agar tidak salah tangkap desa/wilayah yang tidak relevan (seperti kasus 'Pagi, Bali')
                $candidateWords = array_values(array_filter(explode(' ', $locationCandidate), function($w) { return strlen($w) >= 4; }));
                $isMatch = false;
                if ($firstCandidateResult && !empty($candidateWords)) {
                    $formattedLower = strtolower($firstCandidateResult['formatted']);
                    foreach ($candidateWords as $cw) {
                        if (str_contains($formattedLower, strtolower($cw))) {
                            $isMatch = true;
                            break;
                        }
                    }
                }

                if ($isMatch) {
                    $loc = $firstCandidateResult;
                } elseif (!empty($candidateWords)) {
                    // 2. Jika kandidat kalimat panjang gagal atau meleset, coba gunakan kata kunci utama (misal: "lhokseumawe")
                    $primaryWord = $candidateWords[0];
                    $geoRes2 = $client->get('https://api.opencagedata.com/geocode/v1/json', [
                        'query' => [
                            'q' => $primaryWord,
                            'key' => $geoKey,
                            'limit' => 1
                        ]
                    ]);
                    $geoData2 = json_decode($geoRes2->getBody(), true);
                    $loc = $geoData2['results'][0] ?? null;
                } else {
                    $loc = $firstCandidateResult;
                }

                if ($loc) {
                    $lat = $loc['geometry']['lat'];
                    $lng = $loc['geometry']['lng'];
                    $formattedName = $loc['formatted'];

                    $weatherRes = $client->get('https://api.openweathermap.org/data/2.5/weather', [
                        'query' => [
                            'lat' => $lat,
                            'lon' => $lng,
                            'appid' => $openWeatherKey,
                            'units' => 'metric',
                            'lang' => 'id'
                        ]
                    ]);
                    $wData = json_decode($weatherRes->getBody(), true);
                    if ($wData && isset($wData['main'])) {
                        $temp = $wData['main']['temp'] ?? 0;
                        $feels = $wData['main']['feels_like'] ?? 0;
                        $humidity = $wData['main']['humidity'] ?? 0;
                        $pressure = $wData['main']['pressure'] ?? 0;
                        $windSpeedMs = $wData['wind']['speed'] ?? 0;
                        $windKnots = round($windSpeedMs * 1.94384, 1);
                        $windDeg = $wData['wind']['deg'] ?? 0;
                        $windDir = $directions[round($windDeg / 45) % 8];
                        $desc = ucfirst($wData['weather'][0]['description'] ?? 'Cerah Berawan');
                        $rain1h = $wData['rain']['1h'] ?? 0;
                        $visibilityKm = isset($wData['visibility']) ? round($wData['visibility'] / 1000, 1) : 10;

                        $maritimeStatus = 'AMAN BERLAYAR (Kategori Normal)';
                        if ($windKnots >= 25 || $rain1h >= 10) {
                            $maritimeStatus = 'BAHAYA (Ekstrem / Badai - Tunda Keberangkatan)';
                        } elseif ($windKnots >= 15 || $rain1h >= 2.5) {
                            $maritimeStatus = 'WASPADA (Gelombang 1.5 - 2.5m - Waspada Kapal Tongkang / LCL)';
                        }

                        return "=== DATA SATELIT & SENSOR CUACA MARITIM REAL-TIME (OpenWeatherMap & OpenCage Live) ===\n"
                             . "Lokasi Terpantau: {$formattedName} (Lat: {$lat}, Lng: {$lng})\n"
                             . "Status Cuaca: {$desc}\n"
                             . "Suhu Udara: {$temp} °C (Terasa: {$feels} °C) | Kelembaban: {$humidity}% | Tekanan Udara: {$pressure} hPa\n"
                             . "Kecepatan Angin: {$windSpeedMs} m/s (~{$windKnots} knot), Arah Angin: {$windDeg}° ({$windDir})\n"
                             . "Curah Hujan (1 Jam): {$rain1h} mm | Jarak Pandang (Visibility): {$visibilityKm} km\n"
                             . "Status Rekomendasi Navigasi: {$maritimeStatus}\n"
                             . "Catatan Penting: Ini adalah data observasi satelit cuaca REAL-TIME DETIK INI. Gunakan data presisi ini untuk menjawab kueri pengguna.";
                    }
                }
            } catch (\Throwable $e) {
                // Abaikan kesalahan dan lanjut ke fallback multi-koridor
            }
        }

        // Skenario 2: Pertanyaan umum rute cuaca / scan multi-koridor maritim strategis
        $corridors = [
            ['name' => 'Selat Sunda (Merak - Bakauheni)', 'lat' => -5.95, 'lng' => 105.75],
            ['name' => 'Laut Natuna Utara (Laut Cina Selatan)', 'lat' => 4.0, 'lng' => 108.0],
            ['name' => 'Laut Jawa (Perairan Masalembu / Surabaya - Balikpapan)', 'lat' => -5.5, 'lng' => 114.5],
            ['name' => 'Selat Malaka (Koridor Perdagangan Global)', 'lat' => 2.5, 'lng' => 101.5],
            ['name' => 'Selat Makassar (Pantau Kalimantan - Sulawesi)', 'lat' => -1.5, 'lng' => 118.5],
        ];

        $corridorResults = [];
        foreach ($corridors as $c) {
            try {
                $wRes = $client->get('https://api.openweathermap.org/data/2.5/weather', [
                    'query' => [
                        'lat' => $c['lat'],
                        'lon' => $c['lng'],
                        'appid' => $openWeatherKey,
                        'units' => 'metric',
                        'lang' => 'id'
                    ]
                ]);
                $wData = json_decode($wRes->getBody(), true);
                if ($wData && isset($wData['main'])) {
                    $desc = ucfirst($wData['weather'][0]['description'] ?? '-');
                    $temp = $wData['main']['temp'] ?? 0;
                    $windSpeed = $wData['wind']['speed'] ?? 0;
                    $windKnots = round($windSpeed * 1.94384, 1);
                    $windDeg = $wData['wind']['deg'] ?? 0;
                    $windDir = $directions[round($windDeg / 45) % 8];
                    $rain1h = $wData['rain']['1h'] ?? 0;

                    $status = 'Aman Berlayar';
                    if ($windKnots >= 25 || $rain1h >= 10) {
                        $status = 'BAHAYA (Ekstrem / Badai)';
                    } elseif ($windKnots >= 15 || $rain1h >= 2.5) {
                        $status = 'WASPADA (Gelombang 1.5 - 2.5m)';
                    }

                    $corridorResults[] = "• **{$c['name']}**: {$desc}, Suhu {$temp}°C, Angin {$windSpeed} m/s (~{$windKnots} knot {$windDir}), Hujan {$rain1h} mm/jam [Status: {$status}]";
                }
            } catch (\Throwable $e) {
                continue;
            }
        }

        if (!empty($corridorResults)) {
            return "=== RADAR SATELIT TELEMETRI CUACA KORIDOR MARITIM GLOBAL (OpenWeatherMap Live) ===\n"
                 . implode("\n", $corridorResults) . "\n"
                 . "Gunakan data observasi sensor satelit live di atas untuk menjawab rute mana yang ekstrem atau aman.";
        }

        return null;
    }
}
