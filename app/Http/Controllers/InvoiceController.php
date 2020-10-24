<?php

namespace App\Http\Controllers;

use App\Models\Fees;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\App;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $pdf = PDF::loadView('layouts.invoice', [
            'fees' => Fees::findOrFail($id)
        ]);

        if(App::environment() == 'production')
            return $pdf->download();
        else
            return $pdf->stream();
    }
}
