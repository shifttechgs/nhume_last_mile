<?php

namespace App\Models;

use App\Enums\TrustTier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransporterProfile extends Model
{
    protected $fillable = [
        'user_id', 'driver_source', 'service_types',
        'trust_tier', 'trust_notes', 'reviewed_by', 'reviewed_at',
        'home_zone_id', 'phone', 'whatsapp', 'bio', 'avatar', 'is_active',
    ];

    protected $casts = [
        'trust_tier'    => TrustTier::class,
        'service_types' => 'array',
        'reviewed_at'   => 'datetime',
        'is_active'     => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_driver_id');
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->user?->name ?? 'Unknown Driver';
    }

    public function getTrustBadgeAttribute(): string
    {
        return match ($this->trust_tier) {
            TrustTier::Verified        => 'Verified',
            TrustTier::IdSubmitted     => 'ID Submitted',
            TrustTier::ManuallyReviewed => 'Nhume Reviewed',
            TrustTier::Unverified      => 'Unverified',
        };
    }
}
