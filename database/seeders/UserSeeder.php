<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@delunas.com',
            'contact_number' => '09555555555',
            'password' => Hash::make('password'),
            'user_type' => 'admin',
            'email_verified_at' => Carbon::now()
        ]);

        User::insert([
            'firstname' => 'patient',
            'lastname' => 'patient',
            'email' => 'patient@delunas.com',
            'contact_number' => '09555555555',
            'password' => Hash::make('password'),
            'user_type' => 'user',
            'email_verified_at' => Carbon::now()
        ]);

        User::insert([
            'firstname' => 'doctor',
            'lastname' => 'doctor',
            'email' => 'doctor@delunas.com',
            'contact_number' => '09555555555',
            'password' => Hash::make('password'),
            'user_type' => 'doctor',
            'email_verified_at' => Carbon::now()
        ]);
    }
}
