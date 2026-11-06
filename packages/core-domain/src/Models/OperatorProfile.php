<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorProfile extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'ops.operator_profiles';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'employee_id',
        'assigned_hub_id',
        'role_tier',
        'wireguard_pubkey',
        'device_fingerprint',
        'kpi_rating',
        'is_on_duty',
    ];

    protected function casts(): array
    {
        return [
            'is_on_duty' => 'boolean',
            'kpi_rating' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function hub()
    {
        return $this->belongsTo(Port::class, 'assigned_hub_id', 'id');
    }
}

