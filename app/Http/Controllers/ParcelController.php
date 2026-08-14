<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;

final class ParcelController extends Controller
{
    public function create(): View
    {
        return view('pages.send');
    }
}
