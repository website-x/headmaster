<?php

namespace App\Http\Controllers;

use App\Models\Description;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function createDescription(Request $request)
    {
        $description = Description::firstOrCreate(['value' => $request->value]);

        return response()->json($description);
    }

    public function createMethod(Request $request)
    {
        $method = PaymentMethod::firstOrCreate(['value' => $request->value]);

        return response()->json($method);
    }
}
