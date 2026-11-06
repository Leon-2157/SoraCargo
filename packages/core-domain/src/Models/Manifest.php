<?php

namespace SoraCargo\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manifest extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'ops.manifests';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'manifest_number',
        'origin_port_id',
        'destination_port_id',
        'vessel_or_vehicle_name',
        'voyage_number',
        'departure_eta',
        'arrival_eta',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'departure_eta' => 'datetime',
            'arrival_eta' => 'datetime',
        ];
    }

    public function originPort()
    {
        return $this->belongsTo(Port::class, 'origin_port_id', 'id');
    }

    public function destinationPort()
    {
        return $this->belongsTo(Port::class, 'destination_port_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(ManifestItem::class, 'manifest_id', 'id');
    }
}

