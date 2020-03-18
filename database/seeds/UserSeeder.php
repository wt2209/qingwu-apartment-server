<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->username = 'admin';
        $user->name = '超级管理员';
        $user->areas = '1,2,3';
        $user->password = bcrypt('admin888');
        $user->save();
    }
}
