<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'admin.invoices';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'invoice_number',
        'company_id',
        'cargo_booking_id',
        'total_invoice_amount',
        'currency',
        'exchange_rate_locked',
        'due_date',
        'payment_status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'total_invoice_amount' => 'decimal:2',
            'exchange_rate_locked' => 'decimal:4',
            'due_date' => 'date',
            'paid_at' => 'datetime',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function cargoBooking()
    {
        return $this->belongsTo(CargoBooking::class, 'cargo_booking_id', 'id');
    }
}

