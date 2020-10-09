<?php

use App\Committee;
use Illuminate\Database\Seeder;

class CommitteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $committees = [
            [ "name" => "Audit Committee" ],
            [ "name" => "HRM&R Committee" ],
            [ "name" => "PAC Committee" ],
            [ "name" => "FMC Committee" ],
            [ "name" => "CSR&S Committee" ],
        ];
        
        Committee::insert($committees);

        $na = Committee::create([
            'name' => 'NA'
        ]);
        $na->id = 0;
        $na->save();
    }
}
