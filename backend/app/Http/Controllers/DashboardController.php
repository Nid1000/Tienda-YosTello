<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();

        return view('dashboard', [
            'user' => $user,
            'orders' => $user->orders()->latest()->take(5)->get(),
        ]);
    }
}
