<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\CreateTaskDTO;
use App\Enums\PickupType;

final class CalculateTaskPriceAction
{
    private const float BASE_PRICE          = 2.50;
    private const float BIKER_COLLECTION_FEE = 2.00;
    private const float FRAGILE_FEE         = 1.00;
    private const float WEIGHT_THRESHOLD_KG  = 5.0;
    private const float WEIGHT_RATE_PER_KG   = 0.50;

    public function execute(CreateTaskDTO $dto): float
    {
        $price = self::BASE_PRICE;

        if ($dto->pickupType === PickupType::BikerCollection) {
            $price += self::BIKER_COLLECTION_FEE;
        }

        if ($dto->weightKg !== null && $dto->weightKg > self::WEIGHT_THRESHOLD_KG) {
            $price += ($dto->weightKg - self::WEIGHT_THRESHOLD_KG) * self::WEIGHT_RATE_PER_KG;
        }

        if ($dto->isFragile) {
            $price += self::FRAGILE_FEE;
        }

        return round($price, 2);
    }
}
