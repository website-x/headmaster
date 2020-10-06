<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Fees;
use App\Models\Office;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Shreyansh Panchal',
            'email' => 'shreyansh@websitex.co',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $this->call([
            RolesAndPermissionsSeeder::class
        ]);

        Office::factory(5)->create()->each(function($office) {

            // Create a user for each office
            $user = (User::factory(1)->make())->first();
            $user->office()->associate($office);
            $user->save();
            $user->assignRole(Role::inRandomOrder()->first());

            // Create a client for each office
            $client = (Client::factory(1)->make())->first();
            $client->createdBy()->associate(User::inRandomOrder()->first());
            $client->office()->associate($office);
            $client->save();

            // Create a fee for client created in the block above
            $fee = (Fees::factory(1)->make())->first();
            $fee->client()->associate($client);
            $fee->office()->associate($office);
            $fee->collectedBy()->associate(User::inRandomOrder()->first());
            $fee->save();
        });
    }
}
