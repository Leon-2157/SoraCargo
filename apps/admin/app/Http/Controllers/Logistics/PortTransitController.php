<?php

namespace App\Http\Controllers\Logistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SoraCargo\Core\Models\Port;
use SoraCargo\Core\Models\Route;

class PortTransitController extends Controller
{
    /**
     * Tampilkan data Pelabuhan & Depo Transit.
     */
    public function index(Request $request)
    {
        $type = $request->query('type');
        $search = $request->query('search');

        $query = Port::with(['originRoutes', 'destinationRoutes', 'operatorProfiles']);

        if (!empty($type)) {
            $query->where('port_type', $type);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'ilike', "%{$search}%")
                  ->orWhere('name', 'ilike', "%{$search}%")
                  ->orWhere('city', 'ilike', "%{$search}%")
                  ->orWhere('country_code', 'ilike', "%{$search}%");
            });
        }

        $ports = $query->orderBy('country_code', 'asc')->orderBy('id', 'asc')->paginate(10)->withQueryString();

        // 4 KPI Agregasi Fasilitas Terminal
        $totalPorts = Port::count();
        $totalSeaports = Port::where('port_type', 'SEAPORT')->count();
        $totalCyCapacity = Port::sum('terminal_cy_capacity_teus');
        $internationalHubs = Port::where('country_code', '!=', 'ID')->count();

        return view('logistics.ports', compact(
            'ports',
            'totalPorts',
            'totalSeaports',
            'totalCyCapacity',
            'internationalHubs',
            'type',
            'search'
        ));
    }

    /**
     * Tambah Simpul Pelabuhan / Depo Transit Baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => ['required', 'string', 'min:3', 'max:10', Rule::unique(Port::class, 'id')],
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country_code' => 'required|string|size:2',
            'port_type' => 'required|in:SEAPORT,AIRPORT,LAND_HUB',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'terminal_cy_capacity_teus' => 'required|integer|min:100|max:100000',
        ]);

        $code = strtoupper(trim($request->id));

        $port = Port::create([
            'id' => $code,
            'name' => $request->name,
            'city' => $request->city,
            'country_code' => strtoupper($request->country_code),
            'port_type' => $request->port_type,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'terminal_cy_capacity_teus' => $request->terminal_cy_capacity_teus,
        ]);

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'CREATE_LOGISTICS_PORT',
            'target_schema' => 'public',
            'target_table' => 'ports',
            'record_id' => $port->id,
            'before_state_json' => null,
            'after_state_json' => json_encode($port->toArray()),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', "Simpul logistik baru {$port->id} - {$port->name} ({$port->city}) berhasil ditambahkan ke jaringan.");
    }

    /**
     * Perbarui Data & Kapasitas Terminal Pelabuhan.
     */
    public function update(Request $request, string $id)
    {
        $port = Port::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country_code' => 'required|string|size:2',
            'port_type' => 'required|in:SEAPORT,AIRPORT,LAND_HUB',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'terminal_cy_capacity_teus' => 'required|integer|min:100|max:100000',
        ]);

        $beforeState = $port->toArray();

        $port->update([
            'name' => $request->name,
            'city' => $request->city,
            'country_code' => strtoupper($request->country_code),
            'port_type' => $request->port_type,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'terminal_cy_capacity_teus' => $request->terminal_cy_capacity_teus,
        ]);

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'UPDATE_LOGISTICS_PORT',
            'target_schema' => 'public',
            'target_table' => 'ports',
            'record_id' => $port->id,
            'before_state_json' => json_encode($beforeState),
            'after_state_json' => json_encode($port->toArray()),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', "Data fasilitas terminal {$port->id} ({$port->name}) berhasil diperbarui.");
    }
}

