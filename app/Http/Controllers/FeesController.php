<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Fees;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class FeesController extends Controller
{
    public function index()
    {
        $office_id = auth()->user()->office_id;
        $role_name = User::find(auth()->user()->id)->role;
        if (strtolower($role_name) == 'admin') {
            $fees_data = Fees::orderByDesc('created_at')->with(['client', 'collectedBy'])->paginate();
        } else {
            $fees_data = Fees::whereHas('office', function (Builder $query) use ($office_id) {
                $query->where('office_id', $office_id);
            })
                ->with(['client', 'collectedBy'])
                ->paginate();
        }
        return Inertia::render('Fees/Index', [
            'fees' => $fees_data
        ]);
    }

    public function create()
    {
        return Inertia::render('Fees/Create', [
            'clients' => Client::get(['id', 'first_name', 'last_name'])->pluck('full_name', 'id')->toArray()
        ]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'amount' => ['required', 'numeric'],
            'client_id' => ['required', 'numeric'],
        ])->validateWithBag('createFees');

        Fees::create([
            'description' => $request->description ?? null,
            'amount' => $request->amount,
            'method' => $request->get('method') ?? null,
            'client_id' => $request->client_id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back();
    }

    public function edit(Fees $fee)
    {
        return Inertia::render('Fees/Edit', [
            'fees' => $fee,
            'clients' => Client::get(['id', 'first_name', 'last_name'])->pluck('full_name', 'id')->toArray()
        ]);
    }

    public function update(Request $request, Fees $fee)
    {
        Validator::make($request->all(), [
            'amount' => ['required', 'numeric'],
            'client_id' => ['required', 'numeric'],
        ])->validateWithBag('updateFees');

        $fee->update([
            'description' => $request->description ?? null,
            'amount' => $request->amount,
            'method' => $request->get('method') ?? null,
            'client_id' => $request->client_id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back();
    }

    public function destroy(Fees $fee)
    {
        $fee->delete();

        return redirect()->route('fees.index');
    }
}
