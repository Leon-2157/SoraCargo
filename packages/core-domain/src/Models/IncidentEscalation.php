<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentEscalation extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'ops.incident_escalations';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'incident_ticket_no',
        'cargo_booking_id',
        'reporter_operator_id',
        'incident_type',
        'requested_amount',
        'bap_document_path',
        'approval_status',
        'admin_notes',
        'sla_response_minutes',
    ];

    protected function casts(): array
    {
        return [
            'requested_amount' => 'decimal:2',
            'sla_response_minutes' => 'integer',
        ];
    }

    public function cargoBooking()
    {
        return $this->belongsTo(CargoBooking::class, 'cargo_booking_id', 'id');
    }

    public function reporter()
    {
        return $this->belongsTo(OperatorProfile::class, 'reporter_operator_id', 'id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('approval_status', 'PENDING_REVIEW');
    }

    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'APPROVED_BY_ADMIN');
    }

    public function scopeRejected($query)
    {
        return $query->where('approval_status', 'REJECTED');
    }

    public function scopeInsurance($query)
    {
        return $query->where('approval_status', 'INSURANCE_PROCESSED');
    }
}

