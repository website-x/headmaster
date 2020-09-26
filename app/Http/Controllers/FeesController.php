<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Fees;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class FeesController extends Controller
{
    public function index()
    {
        return Inertia::render('Fees/Index', [
            'fees' => Fees::orderByDesc('created_at')->with(['client','collectedBy'])->paginate()
        ]);
    }

    public function create()
    {
        return Inertia::render('Fees/Create',[
            'clients' => Client::get(['id','first_name','last_name'])->pluck('full_name','id')->toArray()
        ]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'amount' => ['required', 'numeric'],
            'client_id' => ['required','numeric'],
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
            'clients' => Client::get(['id','first_name','last_name'])->pluck('full_name','id')->toArray()
        ]);
    }

    public function update(Request $request, Fees $fee)
    {
        Validator::make($request->all(), [
            'amount' => ['required', 'numeric'],
            'client_id' => ['required','numeric'],
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
