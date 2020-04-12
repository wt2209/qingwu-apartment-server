<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(RoomSeeder::class);
        if (App::environment('local') || App::environment('testing')) {
            $this->call(CategorySeeder::class);
            $this->call(PersonSeeder::class);
            $this->call(CompanySeeder::class);
        }
    }
}
