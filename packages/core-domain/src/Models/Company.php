<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'public.companies';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'company_name',
        'nib',
        'npwp',
        'company_address',
        'pic_name',
        'pic_phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function credit()
    {
        return $this->hasOne(CorporateCredit::class, 'company_id', 'id');
    }

    public function corporateCredit()
    {
        return $this->hasOne(CorporateCredit::class, 'company_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'company_id', 'id');
    }

    public function bookings()
    {
        return $this->hasMany(CargoBooking::class, 'company_id', 'id');
    }
}

