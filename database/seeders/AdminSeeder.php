<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name'      => 'Admin',
                'email'     => 'admin@green.edu.bd',
                'username'  => 'admin',
                'type'      => 'admin',
                'password'  => bcrypt('123456')
            ],
        ]);
    }
}
