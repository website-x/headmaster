<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->is_admin) {
            $office_data = Office::paginate();
        } else {
            $office_data = User::find(auth()->user()->id)->office()->paginate();
        }

        return Inertia::render('Offices/Index', [
            'offices' => $office_data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Offices/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'address' => ['nullable', 'unique:offices,address'],
            'phone' => ['nullable', 'unique:offices,phone'],
        ])->validateWithBag('createOffice');

        Office::create([
            'name' => $request->name,
            'address' => $request->address ?? null,
            'country' => $request->country ?? null,
            'state' => $request->state ?? null,
            'city' => $request->city ?? null,
            'phone' => $request->phone ?? null,
            'email' => $request->email ?? null,
        ]);

        return redirect()->route('offices.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        return Inertia::render('Offices/Edit', [
            'office' => $office->load('employees'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $office)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'address' => ['nullable', "unique:offices,address,{$office->id}"],
            'phone' => ['nullable', "unique:offices,phone,{$office->id}"],
        ])->validateWithBag('updateOffice');

        $office->update([
            'name' => $request->name,
            'address' => $request->address ?? null,
            'country' => $request->country ?? null,
            'state' => $request->state ?? null,
            'city' => $request->city ?? null,
            'phone' => $request->phone ?? null,
            'email' => $request->email ?? null,
        ]);

        return redirect()->route('offices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        $office->delete();

        return redirect()->route('offices.index');
    }
}
