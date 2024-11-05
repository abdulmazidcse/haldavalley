<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $user = User::insert([
            ['name'=>'Super Admin', 'email' => 'superadmin@gmail.com', 'password' => bcrypt('password')],
            ['name'=>'Admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('password')]
        ]);
    }
}
