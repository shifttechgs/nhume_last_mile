<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryRoute extends Model
{
    protected $table = 'routes';

    protected $fillable = [
        'origin_city',
        'destination_city',
        'origin_code',
        'destination_code',
        'distance_km',
        'typical_duration_mins',
        'is_active',
    ];

    protected $casts = [
        'distance_km'          => 'float',
        'typical_duration_mins'=> 'integer',
        'is_active'            => 'boolean',
    ];

    public function getDisplayNameAttribute(): string
    {
        return "{$this->origin_city} → {$this->destination_city}";
    }

    public function journeys(): HasMany
    {
        return $this->hasMany(Journey::class, 'route_id');
    }
}
