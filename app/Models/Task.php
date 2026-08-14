<?php

namespace App\Models;

use App\Enums\OrderSource;
use App\Enums\PackageCategory;
use App\Enums\PickupType;
use App\Enums\ServiceType;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'preferred_zone_id', 'shift_id',
        'collection_point_id', 'service_type', 'status',
        'pickup_type', 'order_source', 'package_category',
        'pickup_address', 'pickup_lat', 'pickup_lng',
        'dropoff_address', 'dropoff_lat', 'dropoff_lng',
        'item_description', 'weight_kg', 'errand_instructions',
        'sender_phone', 'recipient_name', 'recipient_phone',
        'offered_price', 'price_estimate', 'is_fragile',
        'notes', 'scheduled_at',
    ];

    protected $casts = [
        'service_type'     => ServiceType::class,
        'status'           => TaskStatus::class,
        'pickup_type'      => PickupType::class,
        'order_source'     => OrderSource::class,
        'package_category' => PackageCategory::class,
        'is_fragile'       => 'boolean',
        'weight_kg'        => 'float',
        'offered_price'    => 'float',
        'price_estimate'   => 'float',
        'scheduled_at'     => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(ServiceZone::class, 'preferred_zone_id');
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(AvailableShift::class, 'shift_id');
    }

    public function collectionPoint(): BelongsTo
    {
        return $this->belongsTo(CollectionPoint::class);
    }
}
