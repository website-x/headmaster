<?php

namespace App\Http\Controllers;

use App\Mail\PaymentReceived;
use App\Models\Client;
use App\Models\Fees;
use App\Models\Setting;
use App\Models\User;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
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
                ->orderBy('created_at','DESC')
                ->paginate();
        }

        return Inertia::render('Fees/Index', [
            'fees' => $fees_data
        ]);
    }

    public function create()
    {
        return Inertia::render('Fees/Create', [
            'clients' => Client::get(['id', 'first_name', 'last_name'])->pluck('full_name', 'id')->toArray(),
            'offices' => Office::get(['id', 'name'])->toArray()
        ]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'client_id' => 'required|numeric',
        ])->sometimes('office_id','required',function($input){
            return auth()->user()->is_admin === true;
        })->validateWithBag('createFees');

        $fees = Fees::create([
            'description' => $request->description ?? null,
            'amount' => $request->amount,
            'method' => $request->get('method') ?? null,
            'client_id' => $request->client_id,
            'office_id' => auth()->user()->is_admin === true ? $request->office_id : auth()->user()->office->id,
            'user_id' => auth()->user()->id,
        ]);

        try {
            Mail::to(Setting::find('email_invoice')->value)
                ->send(new PaymentReceived($fees));
        } catch(\Exception $e) {
            report($e);
        }

        return redirect()->route('fees.index');
    }

    public function edit(Fees $fee)
    {
        return Inertia::render('Fees/Edit', [
            'fees' => $fee,
            'clients' => Client::get(['id', 'first_name', 'last_name'])->pluck('full_name', 'id')->toArray(),
            'offices' => Office::get(['id', 'name'])->toArray()
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
    public function generate_fullexport($txt)
    {
        $role_name = auth()->user()->role;
        $office_id = auth()->user()->office_id;
        if (strtolower($role_name) == 'admin') {
            $data = Fees::orderByDesc('created_at')->with(['client', 'collectedBy'])->get();
        } else {
            $data = Fees::whereHas('office', function (Builder $query) use ($office_id) {
                $query->where('office_id', $office_id);
            })
                ->with(['client', 'collectedBy'])
                ->orderBy('created_at','DESC')
                ->get();
        }
        if (strtolower($txt) == 'csv') {
            $fileName = 'payments.csv';
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
            $columns = array('Invoice number', 'Date', 'Name', 'Amount','Collected By','Office name');
            $callback = function () use ($data, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($data as $data) {
                    $officename=isset($data->office)?$data->office->name:'';
                    $row['Invoice number']  = $data->id;
                    $row['Date']    = $data->last_created_at;
                    $row['Name']    = $data->client->full_name;
                    $row['Amount']  = $data->amount;
                    $row['Collected By']  = $data->collectedBy->name;
                    $row['Office name']  = $officename;


                    fputcsv($file, array($row['Invoice number'], $row['Date'], $row['Name'], $row['Amount'], $row['Collected By'], $row['Office name']));
                }


                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } else {
            $pdf = PDF::loadView('pdf.feesexport', ['fees' => $data]);
            return $pdf->stream('payments.pdf');
        }
    }
}
