<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'firstname' => 'Yann',
            'lastname' => 'Ghistelinck',
            'email' => 'yann@test.fr',
            'email_verified_at' => now(),
            'password' => Hash::make('testtest'),
            'remember_token' => Str::random(10),
            'role_id' => '2'
        ]);
        
        User::create([
            'firstname' => 'utilisateur',
            'lastname' => 'nom',
            'email' => 'user@test.fr',
            'email_verified_at' => now(),
            'password' => Hash::make('testtest'),
            'remember_token' => Str::random(10),
            'role_id' => '1'
        ]);

        User::factory(8)->create();
    }
}
