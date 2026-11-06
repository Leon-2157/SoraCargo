<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueSplit extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'admin.revenue_splits';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'cargo_booking_id',
        'platform_fee_amount',
        'operator_share_amount',
        'tax_and_port_dues',
        'net_platform_profit',
    ];

    protected function casts(): array
    {
        return [
            'platform_fee_amount' => 'decimal:2',
            'operator_share_amount' => 'decimal:2',
            'tax_and_port_dues' => 'decimal:2',
            'net_platform_profit' => 'decimal:2',
        ];
    }

    public function cargoBooking()
    {
        return $this->belongsTo(CargoBooking::class, 'cargo_booking_id', 'id');
    }
}

