<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\OrderSource;
use App\Enums\PackageCategory;
use App\Enums\PickupType;
use App\Enums\ServiceType;
use Illuminate\Support\Carbon;

final readonly class CreateTaskDTO
{
    public function __construct(
        public PickupType       $pickupType,
        public ServiceType      $serviceType,
        public OrderSource      $orderSource,
        public string           $dropoffAddress,
        public string           $recipientName,
        public string           $recipientPhone,
        public PackageCategory  $packageCategory,
        public ?int             $collectionPointId,
        public ?string          $pickupAddress,
        public ?string          $itemDescription,
        public ?float           $weightKg,
        public bool             $isFragile,
        public ?string          $notes,
        public ?Carbon          $scheduledAt,
        public ?int             $userId,
    ) {}
}
