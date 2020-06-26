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
        $this->call(FeeTypeSeeder::class);
        $this->call(ChargeRuleSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PersonSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(RoomSeeder::class);
    }
}
