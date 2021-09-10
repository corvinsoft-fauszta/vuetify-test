<?php

namespace Database\Seeders;

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
        if (User::where("email", "user@user.com")->get()->isEmpty()) {
            $user = User::factory()->raw();
            $user['email'] = "user@user.com";
            User::create($user);
        }
        User::factory(10)->create();

        $this->call([
                        TicketSeeder::class,
                    ]);
    }
}
