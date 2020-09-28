<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Office;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => User::where('id','!=',auth()->id())->orderByDesc('created_at')->paginate()
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create',[
            'offices' => Office::get(['id','name'])->pluck('name','id')->toArray(),
            'roles' => Role::get('name')->pluck('name')->toArray()
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
            'office_id' => $request->office_id ?? null
        ]);

        $user->assignRole($request->role);

        return redirect()->back();
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => $user,
            'offices' => Office::get(['id','name'])->pluck('name','id')->toArray(),
            'roles' => Role::get('name')->pluck('name')->toArray()
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
            'office_id' => $request->office_id ?? null
        ]);

        $user->removeRole($user->role);

        $user->assignRole($request->role);

        return redirect()->back();
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
