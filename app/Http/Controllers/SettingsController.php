<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        return Inertia::render('Settings/Index', [
            'settings' => Setting::paginate(),
        ]);
    }

    public function edit(Setting $setting)
    {
        return Inertia::render('Settings/Edit', [
            'setting' => $setting,
        ]);
    }

    public function update(Request $request, Setting $setting)
    {
        Validator::make($request->all(), [
            'value' => 'required',
        ])->validateWithBag('updateSettings');

        $setting->update([
            'value' => $request->input('value'),
        ]);

        return redirect()->route('settings.index');
    }
}
