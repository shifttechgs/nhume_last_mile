<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\CreateTaskAction;
use App\DTOs\CreateTaskDTO;
use App\Models\Task;

final class ParcelOrderService
{
    public function __construct(
        private readonly CreateTaskAction $createTask,
    ) {}

    public function placeOrder(CreateTaskDTO $dto): Task
    {
        return $this->createTask->execute($dto);
    }
}
