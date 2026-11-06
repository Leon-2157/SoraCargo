<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscrowLedger extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'admin.escrow_ledgers';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'cargo_booking_id',
        'total_paid_amount',
        'milestone_1_pickup_amount',
        'milestone_1_released_at',
        'milestone_2_sailing_amount',
        'milestone_2_released_at',
        'milestone_3_delivered_amount',
        'milestone_3_released_at',
        'escrow_status',
    ];

    protected function casts(): array
    {
        return [
            'total_paid_amount' => 'decimal:2',
            'milestone_1_pickup_amount' => 'decimal:2',
            'milestone_1_released_at' => 'datetime',
            'milestone_2_sailing_amount' => 'decimal:2',
            'milestone_2_released_at' => 'datetime',
            'milestone_3_delivered_amount' => 'decimal:2',
            'milestone_3_delivered_amount' => 'decimal:2',
            'milestone_3_released_at' => 'datetime',
        ];
    }

    public function cargoBooking()
    {
        return $this->belongsTo(CargoBooking::class, 'cargo_booking_id', 'id');
    }
}

