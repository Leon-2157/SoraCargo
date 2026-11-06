<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsCode extends Model
{
    use HasFactory;

    protected $table = 'public.hs_codes';

    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'code',
        'description_id',
        'description_en',
        'import_duty_pct',
        'vat_pct',
        'income_tax_pct',
        'has_lartas_restriction',
        'required_permit_agency',
    ];

    protected function casts(): array
    {
        return [
            'import_duty_pct' => 'decimal:2',
            'vat_pct' => 'decimal:2',
            'income_tax_pct' => 'decimal:2',
            'has_lartas_restriction' => 'boolean',
        ];
    }

    public function cargoBookings()
    {
        return $this->hasMany(CargoBooking::class, 'hs_code', 'code');
    }
}

