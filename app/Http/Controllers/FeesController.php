<?php

namespace App\Http\Controllers;

use App\Mail\PaymentReceived;
use App\Models\Client;
use App\Models\Description;
use App\Models\Fees;
use App\Models\Office;
use App\Models\PaymentMethod;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use PDF;

class FeesController extends Controller
{
    public function index()
    {
        $office_id = auth()->user()->office_id;

        $role_name = auth()->user()->role;

        if (strtolower($role_name) == 'admin') {
            $fees_data = Fees::orderByDesc('created_at')->with(['client', 'collectedBy', 'office'])->paginate();
        } else {
            $fees_data = Fees::whereHas('office', function (Builder $query) use ($office_id) {
                $query->where('office_id', $office_id);
            })
                ->with(['client', 'collectedBy', 'office'])
                ->orderBy('created_at', 'DESC')
                ->paginate();
        }

        return Inertia::render('Fees/Index', [
            'fees_data' => $fees_data,
        ]);
    }

    public function create()
    {
        return Inertia::render('Fees/Create', [
            'clients' => Client::get(['id', 'first_name', 'last_name'])->pluck('full_name', 'id')->toArray(),
            'offices' => Office::get(['id', 'name'])->toArray(),
            'descriptions' => Description::get()->toArray(),
            'methods' => PaymentMethod::get()->toArray(),
        ]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'client_id' => 'required|numeric',
            'description' => 'required',
            'method' => 'required',
        ])->sometimes('office_id', 'required', function ($input) {
            return auth()->user()->is_admin;
        })->validateWithBag('createFees');

        $fees = Fees::create([
            'description' => optional($request->description)['value'] ?? null,
            'amount' => $request->amount,
            'method' => optional($request->get('method'))['value'] ?? null,
            'method_remarks' => $request->get('method_remarks') ?? null,
            'client_id' => $request->client_id,
            'office_id' => auth()->user()->is_admin === true ? $request->office_id : auth()->user()->office->id,
            'user_id' => auth()->user()->id,
        ]);

        try {
            Mail::to(Setting::find('email_invoice')->value)
                ->send(new PaymentReceived($fees));
        } catch (\Exception $e) {
            report($e);
        }

        return redirect()->route('fees.index');
    }

    public function edit(Fees $fee)
    {
        $canDelete = 0;
        if(\Auth::user()->hasRole('admin')){
            $canDelete = 1;
        }
        return Inertia::render('Fees/Edit', [
            'fees' => $fee,
            'clients' => Client::get(['id', 'first_name', 'last_name'])->pluck('full_name', 'id')->toArray(),
            'offices' => Office::get(['id', 'name'])->toArray(),
            'descriptions' => Description::get()->toArray(),
            'methods' => PaymentMethod::get()->toArray(),
            'canDelete' => $canDelete
        ]);
    }

    public function update(Request $request, Fees $fee)
    {
        Validator::make($request->all(), [
            'amount' => ['required', 'numeric'],
            'client_id' => ['required', 'numeric'],
            'description' => 'required',
            'method' => 'required',
        ])->sometimes('office_id', 'required', function ($input) {
            return auth()->user()->is_admin;
        })->validateWithBag('updateFees');

        $fee->update([
            'description' => optional($request->description)['value'] ?? null,
            'amount' => $request->amount,
            'method' => optional($request->get('method'))['value'] ?? null,
            'client_id' => $request->client_id,
            'office_id' => auth()->user()->is_admin === true ? $request->office_id : auth()->user()->office->id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('fees.index');
    }

    public function destroy(Fees $fee)
    {
        $fee->delete();

        return redirect()->route('fees.index');
    }
}
