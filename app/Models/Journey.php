<?php

namespace App\Models;

use App\Enums\JourneySource;
use App\Enums\JourneyStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Journey extends Model
{
    protected $fillable = [
        'route_id',
        'transporter_profile_id',
        'vehicle_id',
        'status',
        'source',
        'departs_at',
        'arrives_at',
        'available_weight_kg',
        'available_slots',
        'price_per_kg',
        'min_price',
        'notes',
        'admin_draft_by',
    ];

    protected $casts = [
        'status'              => JourneyStatus::class,
        'source'              => JourneySource::class,
        'departs_at'          => 'datetime',
        'arrives_at'          => 'datetime',
        'available_weight_kg' => 'float',
        'available_slots'     => 'integer',
        'price_per_kg'        => 'float',
        'min_price'           => 'float',
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(DeliveryRoute::class, 'route_id');
    }

    public function transporter(): BelongsTo
    {
        return $this->belongsTo(TransporterProfile::class, 'transporter_profile_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function adminDraftBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_draft_by');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
