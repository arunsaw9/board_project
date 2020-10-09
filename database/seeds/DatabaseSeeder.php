<?php

use Illuminate\Database\Seeder;

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
        $this->call(MsezSeeder::class);
        // $this->call(OmplSeeder::class);
        // $this->call(OtpcSeeder::class);
        // $this->call(OpalSeeder::class);
        // $this->call(MrplSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(CommitteeSeeder::class);
        // $this->call(MeetingSeeder::class);
    }
}
