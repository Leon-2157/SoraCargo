<?php

namespace App\Http\Controllers\Logistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SoraCargo\Core\Models\Route;
use SoraCargo\Core\Models\Port;

class TariffRouteController extends Controller
{
    /**
     * Tampilkan katalog Tarif & Rute Ekspedisi.
     */
    public function index(Request $request)
    {
        $mode = $request->query('mode');
        $hold = $request->query('hold');
        $search = $request->query('search');

        $query = Route::with(['originPort', 'destinationPort', 'bookings']);

        if (!empty($mode)) {
            $query->where('transport_mode', $mode);
        }

        if ($hold === 'active') {
            $query->where('is_weather_hold', false);
        } elseif ($hold === 'held') {
            $query->where('is_weather_hold', true);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('origin_port_id', 'ilike', "%{$search}%")
                  ->orWhere('destination_port_id', 'ilike', "%{$search}%")
                  ->orWhereHas('originPort', function ($op) use ($search) {
                      $op->where('name', 'ilike', "%{$search}%")->orWhere('city', 'ilike', "%{$search}%");
                  })
                  ->orWhereHas('destinationPort', function ($dp) use ($search) {
                      $dp->where('name', 'ilike', "%{$search}%")->orWhere('city', 'ilike', "%{$search}%");
                  });
            });
        }

        $routes = $query->orderBy('origin_port_id')->paginate(10)->withQueryString();
        $ports = Port::orderBy('name')->get();

        // 4 KPI Agregasi Master Tarif
        $totalActiveRoutes = Route::where('is_weather_hold', false)->count();
        $totalWeatherHoldRoutes = Route::where('is_weather_hold', true)->count();
        $avgRatePerKg = Route::avg('base_rate_per_kg') ?? 0;
        $avgTransitHours = Route::avg('estimated_transit_hours') ?? 0;

        return view('logistics.tariffs', compact(
            'routes',
            'ports',
            'totalActiveRoutes',
            'totalWeatherHoldRoutes',
            'avgRatePerKg',
            'avgTransitHours',
            'mode',
            'hold',
            'search'
        ));
    }

    /**
     * Tambah Rute Baru & Tarif Dasar.
     */
    public function store(Request $request)
    {
        $request->validate([
            'origin_port_id' => ['required', Rule::exists(Port::class, 'id')],
            'destination_port_id' => ['required', 'different:origin_port_id', Rule::exists(Port::class, 'id')],
            'transport_mode' => 'required|in:SEA_CONTAINER,SEA_RORO,AIR_FREIGHT,LAND_TRUCK',
            'base_rate_per_kg' => 'required|numeric|min:500',
            'base_rate_per_cbm' => 'required|numeric|min:10000',
            'estimated_transit_hours' => 'required|integer|min:1|max:720',
        ]);

        $route = Route::create([
            'origin_port_id' => $request->origin_port_id,
            'destination_port_id' => $request->destination_port_id,
            'transport_mode' => $request->transport_mode,
            'base_rate_per_kg' => $request->base_rate_per_kg,
            'base_rate_per_cbm' => $request->base_rate_per_cbm,
            'estimated_transit_hours' => $request->estimated_transit_hours,
            'is_weather_hold' => false,
        ]);

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'CREATE_LOGISTICS_ROUTE',
            'target_schema' => 'public',
            'target_table' => 'routes',
            'record_id' => $route->id,
            'before_state_json' => null,
            'after_state_json' => json_encode($route->toArray()),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', "Rute baru {$route->origin_port_id} &rarr; {$route->destination_port_id} ({$route->transport_mode}) berhasil didaftarkan.");
    }

    /**
     * Perbarui Nilai Tarif Dasar Rute.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'base_rate_per_kg' => 'required|numeric|min:500',
            'base_rate_per_cbm' => 'required|numeric|min:10000',
            'estimated_transit_hours' => 'required|integer|min:1|max:720',
            'transport_mode' => 'required|in:SEA_CONTAINER,SEA_RORO,AIR_FREIGHT,LAND_TRUCK',
        ]);

        $route = Route::findOrFail($id);
        $beforeState = $route->toArray();

        $route->update([
            'base_rate_per_kg' => $request->base_rate_per_kg,
            'base_rate_per_cbm' => $request->base_rate_per_cbm,
            'estimated_transit_hours' => $request->estimated_transit_hours,
            'transport_mode' => $request->transport_mode,
        ]);

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'UPDATE_LOGISTICS_ROUTE_TARIFF',
            'target_schema' => 'public',
            'target_table' => 'routes',
            'record_id' => $route->id,
            'before_state_json' => json_encode($beforeState),
            'after_state_json' => json_encode($route->toArray()),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', "Tarif rute {$route->origin_port_id} &rarr; {$route->destination_port_id} berhasil diperbarui.");
    }

    /**
     * Saklar Weather Hold BMKG (Buka / Tutup Koridor Cuaca Buruk).
     */
    public function toggleWeatherHold(Request $request, string $id)
    {
        $request->validate([
            'reason' => 'required|string|min:5|max:500',
        ]);

        $route = Route::findOrFail($id);
        $beforeState = $route->toArray();
        $route->is_weather_hold = !$route->is_weather_hold;
        $route->save();

        $statusLabel = $route->is_weather_hold ? 'DITUTUP SEMENTARA (Weather Hold BMKG)' : 'DIBUKA KEMBALI (Jalur Aman Berlayar)';

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'TOGGLE_ROUTE_WEATHER_HOLD',
            'target_schema' => 'public',
            'target_table' => 'routes',
            'record_id' => $route->id,
            'before_state_json' => json_encode($beforeState),
            'after_state_json' => json_encode([
                'is_weather_hold' => $route->is_weather_hold,
                'reason' => $request->reason,
            ]),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', "Status Rute {$route->origin_port_id} &rarr; {$route->destination_port_id} {$statusLabel}.");
    }
}

