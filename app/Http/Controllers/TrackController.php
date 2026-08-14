<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use Illuminate\View\View;

final class TrackController extends Controller
{
    public function __construct(
        private readonly TaskRepository $tasks,
    ) {}

    public function show(?string $orderNumber = null): View
    {
        if ($orderNumber === null) {
            return view('pages.track', ['orderNumber' => null, 'task' => null]);
        }

        $orderNumber = strtoupper(trim($orderNumber));

        return view('pages.track', [
            'orderNumber' => $orderNumber,
            'task'        => $this->tasks->findByOrderNumber($orderNumber),
        ]);
    }
}
