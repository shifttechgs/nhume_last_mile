<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Task;

final class TaskRepository
{
    public function create(array $attributes): Task
    {
        return Task::create($attributes);
    }

    public function findByOrderNumber(string $orderNumber): ?Task
    {
        return Task::where('order_number', $orderNumber)->first();
    }

    public function orderNumberExists(string $orderNumber): bool
    {
        return Task::where('order_number', $orderNumber)->exists();
    }
}
