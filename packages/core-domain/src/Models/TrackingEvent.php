<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingEvent extends Model
{
    use HasFactory;

    protected $table = 'ops.tracking_events';

    public $timestamps = false; // Only event_timestamp and created_at

    protected $fillable = [
        'cargo_booking_id',
        'event_name',
        'current_status',
        'latitude',
        'longitude',
        'operator_id',
        'event_timestamp',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'event_timestamp' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function cargoBooking()
    {
        return $this->belongsTo(CargoBooking::class, 'cargo_booking_id', 'id');
    }

    public function operator()
    {
        return $this->belongsTo(OperatorProfile::class, 'operator_id', 'id');
    }
}

