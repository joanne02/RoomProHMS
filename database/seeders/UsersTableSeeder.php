<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
        [   'username'=> 'Superadmin',
            'email' =>'admin@example.com',
            'password'=> Hash::make('superadmin'),
            'usertype'=> 'superadmin',
            'status'=> 'active',
        ],
        
        [
            'username'=> 'User',
            'email'=> 'user10000@example.com',
            'password'=>Hash::make('user10000'),
            'usertype' => 'user',
            'status' => 'active'
        ],
        ]);
    }
}
