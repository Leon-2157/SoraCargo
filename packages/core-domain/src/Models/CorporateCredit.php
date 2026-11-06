<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateCredit extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'admin.corporate_credits';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'company_id',
        'credit_limit_amount',
        'used_credit_amount',
        'top_days',
        'kyc_status',
        'bank_guarantee_ref',
        'debt_enforcement_stage',
        'verified_by_admin_id',
        'legality_verified_by_admin_id',
        'legality_verified_at',
        'credit_approved_by_admin_id',
        'credit_approved_at',
        'legality_notes',
        'dispensation_notes',
    ];

    protected function casts(): array
    {
        return [
            'credit_limit_amount' => 'decimal:2',
            'used_credit_amount' => 'decimal:2',
            'top_days' => 'integer',
            'legality_verified_at' => 'datetime',
            'credit_approved_at' => 'datetime',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by_admin_id', 'id');
    }

    public function legalityVerifier()
    {
        return $this->belongsTo(User::class, 'legality_verified_by_admin_id', 'id');
    }

    public function creditApprover()
    {
        return $this->belongsTo(User::class, 'credit_approved_by_admin_id', 'id');
    }

    /**
     * Hitung persentase pemakaian plafon kredit.
     */
    public function utilizationPercentage(): float
    {
        if ($this->credit_limit_amount <= 0) {
            return 0.0;
        }

        return round(($this->used_credit_amount / $this->credit_limit_amount) * 100, 1);
    }

    /**
     * Sisa plafon kredit yang masih dapat digunakan untuk booking kargo.
     */
    public function remainingCredit(): float
    {
        return max(0.0, (float) ($this->credit_limit_amount - $this->used_credit_amount));
    }
}
