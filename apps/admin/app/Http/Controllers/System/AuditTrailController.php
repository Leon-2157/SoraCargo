<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SoraCargo\Core\Models\AuditTrail;
use SoraCargo\Core\Models\User;

class AuditTrailController extends Controller
{
    /**
     * Tampilkan Catatan Aktivitas Permanen (Immutable Audit Trail).
     */
    public function index(Request $request)
    {
        $action = $request->query('action');
        $table = $request->query('table');
        $search = $request->query('search');

        $query = AuditTrail::with('adminUser');

        if (!empty($action)) {
            $query->where('action_type', $action);
        }

        if (!empty($table)) {
            $query->where('target_table', $table);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('action_type', 'ilike', "%{$search}%")
                  ->orWhere('record_id', 'ilike', "%{$search}%")
                  ->orWhere('ip_address', 'ilike', "%{$search}%")
                  ->orWhere('target_table', 'ilike', "%{$search}%")
                  ->orWhereHas('adminUser', function ($au) use ($search) {
                      $au->where('name', 'ilike', "%{$search}%")->orWhere('email', 'ilike', "%{$search}%");
                  });
            });
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // 4 KPI Agregasi Forensik Audit Trail
        $totalLogs = AuditTrail::count();
        $financialMutations = AuditTrail::whereIn('target_table', ['escrow_ledgers', 'invoices', 'corporate_credits'])->count();
        $operationalMutations = AuditTrail::whereIn('target_table', ['cargo_bookings', 'manifests', 'routes', 'operator_profiles'])->count();
        $uniqueAdminsCount = AuditTrail::distinct('admin_user_id')->count('admin_user_id');

        // Distinct action types and tables for filter dropdowns
        $actionTypes = AuditTrail::distinct()->pluck('action_type')->sort();
        $targetTables = AuditTrail::distinct()->pluck('target_table')->sort();

        return view('system.audit', compact(
            'logs',
            'totalLogs',
            'financialMutations',
            'operationalMutations',
            'uniqueAdminsCount',
            'actionTypes',
            'targetTables',
            'action',
            'table',
            'search'
        ));
    }

    /**
     * Ambil detail payload before/after state dalam JSON untuk Modal Inspector.
     */
    public function show(string $id)
    {
        $log = AuditTrail::with('adminUser')->findOrFail($id);

        return response()->json([
            'id' => $log->id,
            'action_type' => $log->action_type,
            'target_table' => $log->target_schema . '.' . $log->target_table,
            'record_id' => $log->record_id,
            'admin_name' => $log->adminUser?->name ?? 'System Automated Hook',
            'admin_email' => $log->adminUser?->email ?? 'system@soracargo.internal',
            'ip_address' => $log->ip_address,
            'user_agent' => $log->user_agent,
            'created_at' => $log->created_at->format('d M Y, H:i:s T'),
            'before_state' => $log->before_state_json,
            'after_state' => $log->after_state_json,
        ]);
    }
}

