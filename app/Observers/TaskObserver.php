<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\TaskStatus;
use App\Events\TaskStatusChanged;
use App\Models\Task;

final class TaskObserver
{
    public function updated(Task $task): void
    {
        if (! $task->wasChanged('status')) {
            return;
        }

        $raw = $task->getOriginal('status');

        $oldStatus = $raw instanceof TaskStatus
            ? $raw
            : TaskStatus::from((string) $raw);

        TaskStatusChanged::dispatch($task, $oldStatus, $task->status);
    }
}
