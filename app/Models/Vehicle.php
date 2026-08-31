<?php

namespace App\Models;

use App\Enums\VehicleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $fillable = [
        'transporter_profile_id',
        'vehicle_type',
        'make',
        'model',
        'year',
        'colour',
        'registration_number',
        'max_weight_kg',
        'is_fleet_asset',
        'is_primary',
    ];

    protected $casts = [
        'vehicle_type'   => VehicleType::class,
        'max_weight_kg'  => 'float',
        'is_fleet_asset' => 'boolean',
        'is_primary'     => 'boolean',
    ];

    public function transporter(): BelongsTo
    {
        return $this->belongsTo(TransporterProfile::class, 'transporter_profile_id');
    }

    public function journeys(): HasMany
    {
        return $this->hasMany(Journey::class);
    }
}
