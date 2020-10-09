<?php

use App\User;
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
        User::create([
            'username' => '128238',
            'name' => 'Sreenath S Das',
            'email' => 'sreenathsdas@gmail.com',
            'role' => 'admin',
            'designation' => 'EE',
            'mobile' => '8259950403',
            'password' => Hash::make('Board@123!'),
            'api_token' => Str::random(60),
        ]);

        // User::create([
        //     'username' => '1000',
        //     'name' => 'VAPT Admin',
        //     'email' => 'admin@gmail.com',
        //     'role' => 'admin',
        //     'designation' => 'EE',
        //     'mobile' => '9015776482',
        //     'password' => Hash::make('Board@123!'),
        //     'api_token' => Str::random(60),
        // ]);

        // User::create([
        //     'username' => '1001',
        //     'name' => 'VAPT User',
        //     'email' => 'user@gmail.com',
        //     'role' => 'user',
        //     'designation' => 'EE',
        //     'mobile' => '9015776482',
        //     'password' => Hash::make('Board@123!'),
        //     'api_token' => Str::random(60),
        // ]);
    }
}
