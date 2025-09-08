<?php

namespace Database\Seeders;

use AppModel\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        \DB::table('users')->truncate();
        User::create(['name'=>'Ramadhani', 'email'=>'ramadhani0470@tugu.com', 'password'=>Hash::make('Ramaganteng8'), 'role'=>'leader']);
        User::create(['name'=>'Septi Rahma Della', 'email'=>'dellaa047@tugu.com', 'password'=>Hash::make('Della123'), 'role'=>'staff']);
        User::create(['name'=>'John Doe', 'email'=>'johndoe047@tugu.com', 'password'=>Hash::make('john123'), 'role'=>'staff']);
    }
}
