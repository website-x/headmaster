<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Office;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Dashboard', [
            'clients_count' => Client::count(),
            'offices_count' => Office::count(),
            'employees_count' => User::count(),
        ]);
    }
}
