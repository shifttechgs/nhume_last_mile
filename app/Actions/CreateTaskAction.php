<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\CreateTaskDTO;
use App\Enums\TaskStatus;
use App\Events\TaskCreated;
use App\Models\Task;
use App\Repositories\TaskRepository;

final class CreateTaskAction
{
    public function __construct(
        private readonly TaskRepository          $tasks,
        private readonly GenerateOrderNumberAction $generateOrderNumber,
        private readonly CalculateTaskPriceAction  $calculatePrice,
    ) {}

    public function execute(CreateTaskDTO $dto): Task
    {
        $orderNumber   = $this->generateOrderNumber->execute();
        $priceEstimate = $this->calculatePrice->execute($dto);

        $task = $this->tasks->create([
            'order_number'        => $orderNumber,
            'user_id'             => $dto->userId,
            'service_type'        => $dto->serviceType,
            'order_source'        => $dto->orderSource,
            'status'              => TaskStatus::Posted,
            'pickup_type'         => $dto->pickupType,
            'collection_point_id' => $dto->collectionPointId,
            'pickup_address'      => $dto->pickupAddress,
            'dropoff_address'     => $dto->dropoffAddress,
            'sender_phone'        => $dto->senderPhone,
            'recipient_name'      => $dto->recipientName,
            'recipient_phone'     => $dto->recipientPhone,
            'package_category'    => $dto->packageCategory,
            'item_description'    => $dto->itemDescription,
            'weight_kg'           => $dto->weightKg,
            'is_fragile'          => $dto->isFragile,
            'notes'               => $dto->notes,
            'scheduled_at'        => $dto->scheduledAt,
            'price_estimate'      => $priceEstimate,
            'offered_price'       => $priceEstimate,
        ]);

        TaskCreated::dispatch($task);

        return $task;
    }
}
