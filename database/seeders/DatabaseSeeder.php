<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Fees;
use App\Models\Office;
use App\Models\Team;
use App\Models\User;
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
        User::factory(1)->create();
        Team::factory(1)->create();

        Office::factory(50)->create()->each(function($office) {

            $client = (Client::factory(1)->make())->first();
            $client->createdBy()->associate(User::first());
            $client->office()->associate($office);
            $client->save();

            $fee = (Fees::factory(1)->make())->first();
            $fee->client()->associate($client);
            $fee->collectedBy()->associate(User::first());
            $fee->save();
        });
    }
}
