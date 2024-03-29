<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $role_name = User::find(auth()->user()->id)->role;
        if (strtolower($role_name) == 'admin') {
            $user_data = User::where('id', '!=', auth()->id())->orderByDesc('created_at')->paginate();
        } else {
            $user_data = User::where('id', '=', auth()->id())->orderByDesc('created_at')->paginate();
        }

        return Inertia::render('Users/Index', [
            'users' => $user_data,
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create', [
            'offices' => Office::get(['id', 'name'])->pluck('name', 'id')->toArray(),
            'roles' => Role::get('name')->pluck('name')->toArray(),
        ]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed'],
            'role' => ['required'],
        ])->validateWithBag('createUser');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'office_id' => $request->office_id ?? null,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => $user,
            'offices' => Office::get(['id', 'name'])->pluck('name', 'id')->toArray(),
            'roles' => Role::get('name')->pluck('name')->toArray(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'role' => ['required'],
        ])->validateWithBag('updateUser');

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'office_id' => $request->office_id ?? null,
        ]);

        $user->removeRole($user->role);

        $user->assignRole($request->role);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
