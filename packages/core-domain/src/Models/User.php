<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $table = 'public.users';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'user_type',
        'admin_role',
        'status',
        'two_factor_secret',
        'two_factor_enabled_at',
        'nik',
        'kyc_aml_status',
        'ktp_verified_at',
        'ktp_file_url',
        'business_type',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'two_factor_enabled_at' => 'datetime',
            'ktp_verified_at' => 'datetime',
        ];
    }

    public function cargoBookings()
    {
        return $this->hasMany(CargoBooking::class, 'shipper_id', 'id');
    }

    public function operatorProfile()
    {
        return $this->hasOne(OperatorProfile::class, 'user_id', 'id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'user_id', 'id');
    }

    public function sentInvitations()
    {
        return $this->hasMany(OperatorInvitation::class, 'invited_by_admin_id', 'id');
    }

    public function auditTrails()
    {
        return $this->hasMany(AuditTrail::class, 'admin_user_id', 'id');
    }
}

