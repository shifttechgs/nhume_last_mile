<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CollectionPoint extends Model
{
    protected $fillable = [
        'service_zone_id', 'name', 'address',
        'lat', 'lng', 'opening_hours', 'phone', 'is_active',
    ];

    protected $casts = [
        'opening_hours' => 'array',
        'is_active'     => 'boolean',
        'lat'           => 'float',
        'lng'           => 'float',
    ];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(ServiceZone::class, 'service_zone_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
