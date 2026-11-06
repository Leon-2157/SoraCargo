<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorInvitation extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'admin.operator_invitations';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'invitation_token',
        'email',
        'phone',
        'assigned_hub_id',
        'assigned_role',
        'expires_at',
        'is_claimed',
        'invited_by_admin_id',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'is_claimed' => 'boolean',
        ];
    }

    public function hub()
    {
        return $this->belongsTo(Port::class, 'assigned_hub_id', 'id');
    }

    public function invitedBy()
    {
        return $this->belongsTo(User::class, 'invited_by_admin_id', 'id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function hoursRemaining(): int
    {
        if ($this->isExpired()) {
            return 0;
        }

        return max(0, (int) now()->diffInHours($this->expires_at, false));
    }
}

