<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Office;
use App\Models\User;
use Inertia\Inertia;
use DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $role_name=User::find(auth()->user()->id)->role;
        $office_id = auth()->user()->office_id;
        $user = User::find(auth()->user()->id);

        /* if (empty($office_id)) {
            $condition = '!=';
        } else {
            $condition = '=';
        }
        $office_data = Office::orderByDesc('offices.id')
            ->select('name', DB::raw('SUM(amount) AS total_amount'), DB::raw('sum(if(date(fees.created_at) = date(now()),amount,0)) as today_amount'),'offices.id as id')
            ->leftjoin('fees', 'offices.id', '=', 'fees.office_id')
            ->where('offices.id', $condition, $office_id)
            ->groupBy('offices.id')
            ->paginate(); */
       
        if (strtolower($role_name)=='admin') {
            $clients_count = Client::count();
            $offices_count = Office::count();
            $employees_count = User::count();
           // $office_data = $office_data;
        } else {
            $clients_count = !empty($user->office()->count())?$user->office->clients()->count():0;
            $offices_count = $user->office()->count();
            $employees_count = User::where('id', '=', $user->id)->count();
           // $office_data = $office_data;
        }
        



        return Inertia::render('Dashboard', [
            'clients_count' => $clients_count,
            'offices_count' => $offices_count,
            'employees_count' => $employees_count,
           // 'office_data' => $office_data
        ]);
    }
}
