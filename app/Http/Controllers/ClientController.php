<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $office_id = auth()->user()->office_id;
        if (empty($office_id)) {
            $clients = Client::with(['office', 'createdBy'])->paginate();
        } else {
            $clients = Client::with(['office', 'createdBy'])->where('office_id', $office_id)->paginate();
        }
        return Inertia::render('Clients/Index', [
            //'clients' => Client::with(['office', 'createdBy'])->paginate()
            'clients' => $clients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Clients/Create');
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
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'father_first_name' => ['required', 'string'],
            'father_last_name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'country' => ['required', 'string'],
            'phone' => ['required', 'unique:clients']
        ])->validateWithBag('createClient');

        Client::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'father_first_name' => $request->father_first_name,
            'father_last_name' => $request->father_last_name,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'phone' => $request->phone,
            'office_id' => Office::first()->id,
            'user_id' => auth()->id()
        ]);

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return Inertia::render('Clients/Edit', [
            'client' => $client->load('payments')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        Validator::make($request->all(), [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'father_first_name' => ['required', 'string'],
            'father_last_name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'country' => ['required', 'string'],
            'phone' => ['required', "unique:clients,phone,{$client->id}",]
        ])->validateWithBag('updateClient');

        $client->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'father_first_name' => $request->father_first_name,
            'father_last_name' => $request->father_last_name,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'phone' => $request->phone,
            'office_id' => Office::first()->id,
            'user_id' => auth()->id()
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index');
    }
}
