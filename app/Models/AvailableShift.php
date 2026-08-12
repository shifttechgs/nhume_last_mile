<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvailableShift extends Model
{
    protected $fillable = [
        'transporter_profile_id', 'service_zone_id',
        'service_types', 'starts_at', 'ends_at',
        'status', 'max_concurrent_tasks', 'notes',
    ];

    protected $casts = [
        'service_types' => 'array',
        'starts_at'     => 'datetime',
        'ends_at'       => 'datetime',
    ];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(ServiceZone::class, 'service_zone_id');
    }
}
