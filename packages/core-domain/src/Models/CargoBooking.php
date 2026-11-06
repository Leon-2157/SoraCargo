<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoBooking extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'ops.cargo_bookings';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tracking_number',
        'shipper_id',
        'company_id',
        'route_id',
        'hs_code',
        'booking_type',
        'cargo_type',
        'total_weight_kg',
        'total_volume_cbm',
        'declared_goods_value',
        'currency',
        'cargo_status',
        'customs_channel',
        'assigned_operator_id',
    ];

    protected function casts(): array
    {
        return [
            'total_weight_kg' => 'decimal:2',
            'total_volume_cbm' => 'decimal:2',
            'declared_goods_value' => 'decimal:2',
        ];
    }

    public function shipper()
    {
        return $this->belongsTo(User::class, 'shipper_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id', 'id');
    }

    public function assignedOperator()
    {
        return $this->belongsTo(OperatorProfile::class, 'assigned_operator_id', 'id');
    }

    public function hsCode()
    {
        return $this->belongsTo(HsCode::class, 'hs_code', 'code');
    }

    public function escrowLedger()
    {
        return $this->hasOne(EscrowLedger::class, 'cargo_booking_id', 'id');
    }

    public function incidentEscalations()
    {
        return $this->hasMany(IncidentEscalation::class, 'cargo_booking_id', 'id');
    }

    public function trackingEvents()
    {
        return $this->hasMany(TrackingEvent::class, 'cargo_booking_id', 'id')->orderBy('event_timestamp', 'desc');
    }

    public function revenueSplit()
    {
        return $this->hasOne(RevenueSplit::class, 'cargo_booking_id', 'id');
    }
}

