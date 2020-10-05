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
        $office_id = auth()->user()->office_id;
        $user = User::find(auth()->user()->id);

        if (empty($office_id)) {
            $clients_count = Client::count();
            $offices_count = Office::count();
            $employees_count = User::count();
        } else {
            $clients_count = $user->office->clients()->count();
            $offices_count = $user->office()->count();
            $employees_count = User::where('id', '=', $user->id)->count();
        }
        return Inertia::render('Dashboard', [
            /* 'clients_count' => Client::count(),
            'offices_count' => Office::count(),
            'employees_count' => User::count(), */
            'clients_count' => $clients_count,
            'offices_count' => $offices_count,
            'employees_count' => $employees_count,
        ]);
    }
}
