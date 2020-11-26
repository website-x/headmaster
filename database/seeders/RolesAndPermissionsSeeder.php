<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $permissions = [
            'clients-list',
            'clients-create',
            'clients-edit',
            'clients-delete',
            'fees-list',
            'fees-create',
            'fees-edit',
            'fees-delete',
            'offices-list',
            'offices-create',
            'offices-edit',
            'offices-delete',
            'users-list',
            'users-create',
            'users-edit',
            'users-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        Role::create(['name' => 'employee']);
        $role = Role::create(['name' => 'admin']);

        $role->givePermissionTo(Permission::all());

        User::orderByDesc('id')->get()->first()->assignRole('admin');
    }
}
