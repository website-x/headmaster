<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Expense;
use App\Models\Office;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::orderByDesc('created_at')
            ->with(['client', 'office', 'spentBy'])
            ->paginate();

        return Inertia::render('Expenses/Index', [
            'expenses' => $expenses,
        ]);
    }

    public function create()
    {
        return Inertia::render('Expenses/Create', [
            'clients' => Client::get(['id', 'first_name', 'last_name'])->pluck('full_name', 'id')->toArray(),
            'offices' => Office::get(['id', 'name'])->toArray(),
            'methods' => PaymentMethod::get()->toArray(),
        ]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'client_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'description' => 'required',
            'method' => 'required',
        ])->validateWithBag('createExpense');

        $fees = Expense::create([
            'description' => $request->description ?? null,
            'amount' => $request->amount,
            'method' => optional($request->get('method'))['value'] ?? null,
            'method_remarks' => $request->get('method_remarks') ?? null,
            'client_id' => $request->client_id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('expenses.index');
    }

    public function edit(Expense $expense)
    {
        return Inertia::render('Expenses/Edit', [
            'expense' => $expense,
            'clients' => Client::get(['id', 'first_name', 'last_name'])->pluck('full_name', 'id')->toArray(),
            'methods' => PaymentMethod::get()->toArray(),
        ]);
    }

    public function update(Request $request, Expense $expense)
    {
        Validator::make($request->all(), [
            'amount' => ['required', 'numeric'],
            'client_id' => ['required', 'numeric'],
            'description' => 'required',
            'method' => 'required',
        ])->validateWithBag('updateExpense');

        $expense->update([
            'description' => $request->description ?? null,
            'amount' => $request->amount,
            'method' => optional($request->get('method'))['value'] ?? null,
            'client_id' => $request->client_id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('expenses.index');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index');
    }
}
