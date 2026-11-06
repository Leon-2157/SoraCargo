<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'public.routes';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'origin_port_id',
        'destination_port_id',
        'transport_mode',
        'base_rate_per_kg',
        'base_rate_per_cbm',
        'estimated_transit_hours',
        'is_weather_hold',
    ];

    protected function casts(): array
    {
        return [
            'base_rate_per_kg' => 'decimal:2',
            'base_rate_per_cbm' => 'decimal:2',
            'estimated_transit_hours' => 'integer',
            'is_weather_hold' => 'boolean',
        ];
    }

    public function originPort()
    {
        return $this->belongsTo(Port::class, 'origin_port_id', 'id');
    }

    public function destinationPort()
    {
        return $this->belongsTo(Port::class, 'destination_port_id', 'id');
    }

    public function bookings()
    {
        return $this->hasMany(CargoBooking::class, 'route_id', 'id');
    }
}

