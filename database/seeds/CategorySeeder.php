<?php

use App\Remark;
use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $minute = Category::create([
            'name' => 'Minutes'
        ]);
        $minute->remarks()->saveMany([
            new Remark(['name' => 'Board', 'code' => 'M1' ]),
            new Remark(['name' => 'Committee', 'code' => 'M2']),
        ]);

        $leave = Category::create([
            'name' => 'Leave of Absence'
        ]);
        $leave->remarks()->saveMany([
            new Remark(['name' => 'Granting', 'code' => 'L1']),
        ]);

        $tour = Category::create([
            'name' => 'Tour Reports'
        ]);
        $tour->remarks()->saveMany([
            new Remark(['name' => 'Information', 'code' => 'T1']),
        ]);

        $finance = Category::create([
            'name' => 'Finance'
        ]);
        $finance->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'F1']),
            new Remark(['name' => 'Information', 'code' => 'F2']),
        ]);

        $exploration = Category::create([
            'name' => 'Exploration'
        ]);
        $exploration->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'E1']),
            new Remark(['name' => 'Information', 'code' => 'E2']),
        ]);

        $ops = Category::create([
            'name' => 'Operations'
        ]);
        $ops->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'OP1']),
            new Remark(['name' => 'Information', 'code' => 'OP2']),
        ]);

        $hr = Category::create([
            'name' => 'Human Resource'
        ]);
        $hr->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'HR1']),
            new Remark(['name' => 'Information', 'code' => 'HR2']),
        ]);

        $bd = Category::create([
            'name' => 'Business Development'
        ]);
        $bd->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'BD1']),
            new Remark(['name' => 'Information', 'code' => 'BD2']),
        ]);

        $subsidaries = Category::create([
            'name' => 'Subsidaries'
        ]);
        $subsidaries->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'S1']),
            new Remark(['name' => 'Information', 'code' => 'S2']),
        ]);

        $cs = Category::create([
            'name' => 'Company Secretariat'
        ]);
        $cs->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'CS1']),
            new Remark(['name' => 'Information', 'code' => 'CS2']),
            new Remark(['name' => 'Granting', 'code' => 'CS3']),
        ]);

        $others = Category::create([
            'name' => 'Others'
        ]);
        $others->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'O1']),
            new Remark(['name' => 'Information', 'code' => 'O2']),
        ]);

    }
}
