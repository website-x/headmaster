<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Office;
use App\Models\Fees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

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
        $role_name = auth()->user()->role;
        if (strtolower($role_name) == 'admin') {
            $clients = Client::with(['office', 'createdBy'])->paginate();
        } else {
            $clients = Client::whereHas('office', function (Builder $query) use ($office_id) {
                $query->where('office_id', $office_id);
            })
                ->with(['office', 'createdBy'])
                ->paginate();
        }
        return Inertia::render('Clients/Index', [
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
        return Inertia::render('Clients/Create', [
            'offices' => Office::get(['id', 'name'])->toArray()
        ]);
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

        if (strtolower(auth()->user()->role) == 'admin' || (strtolower(auth()->user()->role) == 'employee'  && auth()->user()->office_id == null)) {
            Validator::make($request->all(), [
                'office_id' => ['required'],
            ])->validateWithBag('createClient');
            $office_id = $request->office_id;
        } else {
            $office_id = auth()->user()->office_id;
        }

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
            'office_id' => $office_id,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('clients.index');
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
            'client' => $client->load('payments'),
            'offices' => Office::get(['id', 'name'])->toArray()
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

        if (strtolower(auth()->user()->role) == 'admin' || (strtolower(auth()->user()->role) == 'employee'  && auth()->user()->office_id == null)) {
            Validator::make($request->all(), [
                'office_id' => ['required'],
            ])->validateWithBag('createClient');
            $office_id = $request->office_id;
        } else {
            $office_id = auth()->user()->office_id;
        }

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
            'office_id' => $office_id,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('clients.index');
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

    public function tnt_searchData(Request $request)
    {
        $office_id = auth()->user()->office_id;
        $role_name = auth()->user()->role;
        $user_id = auth()->user()->id;

        $selectOption = !empty($request->selectOption) ? $request->selectOption : '';
        $searchItem = !empty($request->searchItem) ? $request->searchItem : '';
        $DataSent=array();
        if (strtolower($selectOption) == 'clients') {
            if (strtolower($role_name) == 'admin') {
                $DataSent = Client::search($searchItem)->get();
            } else {
                $DataSent = Client::search($searchItem)->where('office_id', $office_id)->get();
            }
        }
        else if (strtolower($selectOption) == 'users') {
            if (strtolower($role_name) == 'admin') {
                $DataSent = User::search($searchItem)->get();
            } else {
                $DataSent = User::search($searchItem)->where('id', $user_id)->get();
            }
        }
        else if (strtolower($selectOption) == 'offices') {
            if (strtolower($role_name) == 'admin') {
                $DataSent = Office::search($searchItem)->get();
            } else {
                $DataSent = Office::search($searchItem)->where('office_id', $office_id)->get();
            }
        }
        else if (strtolower($selectOption) == 'fees') {
            if (strtolower($role_name) == 'admin') {

                $DataSent = Fees::search($searchItem)->get();

            } else {
                $DataSent = Fees::search($searchItem)->where('office_id', $office_id)->get();
            }
        }

     return response()->json($DataSent);
    }
}
