<?php

declare(strict_types=1);

namespace App\Actions;

use App\Repositories\TaskRepository;

final class GenerateOrderNumberAction
{
    public function __construct(
        private readonly TaskRepository $tasks,
    ) {}

    public function execute(): string
    {
        $date = now()->format('Ymd');

        do {
            $suffix = strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 4));
            $number = "NHM-{$date}-{$suffix}";
        } while ($this->tasks->orderNumberExists($number));

        return $number;
    }
}
