<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

    protected $table = 'admin.immutable_audit_trails';

    public $timestamps = false; // Only has created_at

    protected $fillable = [
        'admin_user_id',
        'action_type',
        'target_schema',
        'target_table',
        'record_id',
        'before_state_json',
        'after_state_json',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'before_state_json' => 'array',
            'after_state_json' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function adminUser()
    {
        return $this->belongsTo(User::class, 'admin_user_id', 'id');
    }
}

