<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    protected $table = 'public.ports';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'city',
        'country_code',
        'port_type',
        'latitude',
        'longitude',
        'terminal_cy_capacity_teus',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'terminal_cy_capacity_teus' => 'integer',
        ];
    }

    public function operatorProfiles()
    {
        return $this->hasMany(OperatorProfile::class, 'assigned_hub_id', 'id');
    }

    public function operatorInvitations()
    {
        return $this->hasMany(OperatorInvitation::class, 'assigned_hub_id', 'id');
    }

    public function originRoutes()
    {
        return $this->hasMany(Route::class, 'origin_port_id', 'id');
    }

    public function destinationRoutes()
    {
        return $this->hasMany(Route::class, 'destination_port_id', 'id');
    }
}

