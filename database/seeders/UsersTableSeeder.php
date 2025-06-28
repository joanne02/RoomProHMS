<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
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
            'username'=> 'User1',
            'email'=> 'user10000@siswa.unimas.my',
            'password'=>Hash::make('Student000#'),
            'usertype' => 'user',
            'status' => 'active'
        ],

        [
            'username'=> 'Staff1',
            'email'=> 'staff10000@unimas.my',
            'password'=>Hash::make('Staff00000#'),
            'usertype' => 'staff',
            'status' => 'active'
        ],
        ]);

        User::factory(250)->create();
    }
}
