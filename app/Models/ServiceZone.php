<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceZone extends Model
{
    protected $fillable = ['name', 'city', 'lat', 'lng', 'radius_km', 'is_active'];

    protected $casts = ['is_active' => 'boolean', 'lat' => 'float', 'lng' => 'float'];

    public function collectionPoints(): HasMany
    {
        return $this->hasMany(CollectionPoint::class);
    }
}
