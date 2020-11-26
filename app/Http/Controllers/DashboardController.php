<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Fees;
use App\Models\Office;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use PDF;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $office_id = auth()->user()->office_id;

        $user = auth()->user();

        if (auth()->user()->is_admin) {
            $condition = '!=';
            $office_id = 0;
            $fees_data = Fees::with(['client', 'collectedBy'])->orderByDESC('created_at')->paginate();
        } else {
            $condition = '=';
            $fees_data = Fees::whereHas('office', function (Builder $query) use ($office_id) {
                $query->where('office_id', $office_id);
            })
                ->with(['client', 'collectedBy'])
                ->orderBy('created_at', 'DESC')
                ->paginate();
        }

        $office_data = Office::orderByDesc('offices.id')
            ->select('name', DB::raw('SUM(amount) AS total_amount'), DB::raw('sum(if(date(fees.created_at) = date(now()),amount,0)) as today_amount'), 'offices.id as id')
            ->leftjoin('fees', 'offices.id', '=', 'fees.office_id')
            ->where('offices.id', $condition, $office_id)
            ->groupBy('offices.id')
            ->paginate();

        if (auth()->user()->is_admin) {
            $clients_count = Client::count();
            $offices_count = Office::count();
            $employees_count = User::count();
            $office_data = $office_data;
        } else {
            $clients_count = ! empty($user->office()->count()) ? $user->office->clients()->count() : 0;
            $offices_count = $user->office()->count();
            $employees_count = User::where('id', '=', $user->id)->count();
            $office_data = $office_data;
        }

        return Inertia::render('Dashboard', [
            'clients_count' => $clients_count,
            'offices_count' => $offices_count,
            'employees_count' => $employees_count,
            'office_data' => $office_data,
            'fees_data' => $fees_data,
        ]);
    }
}
