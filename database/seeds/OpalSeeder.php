<?php

use App\Remark;
use App\Category;
use App\Committee;
use Illuminate\Database\Seeder;

class OpalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leave = Category::create([
            'name' => 'Leave of Absence'
        ]);
        $leave->remarks()->saveMany([
            new Remark(['name' => 'Granting', 'code' => 'L1']),
        ]);

        $minute = Category::create([
            'name' => 'Minutes'
        ]);
        $minute->remarks()->saveMany([
            new Remark(['name' => 'Board', 'code' => 'M1']),
            new Remark(['name' => 'Committee', 'code' => 'M2']),
        ]);

        $finance = Category::create([
            'name' => 'Finance'
        ]);
        $finance->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'F1']),
            new Remark(['name' => 'Information', 'code' => 'F2']),
            new Remark(['name' => 'Noting', 'code' => 'F3']),
        ]);

        $op = Category::create([
            'name' => 'Operations'
        ]);
        $op->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'OP1']),
            new Remark(['name' => 'Information', 'code' => 'OP2']),
            new Remark(['name' => 'Noting', 'code' => 'OP3']),
        ]);

        $projects = Category::create([
            'name' => 'Projects'
        ]);
        $projects->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'PR1']),
            new Remark(['name' => 'Information', 'code' => 'PR2']),
            new Remark(['name' => 'Noting', 'code' => 'PR3']),
        ]);

        $marketing = Category::create([
            'name' => 'Marketing'
        ]);
        $marketing->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'MKT1']),
            new Remark(['name' => 'Information', 'code' => 'MKT2']),
            new Remark(['name' => 'Noting', 'code' => 'MKT3']),
        ]);

        $hr = Category::create([
            'name' => 'Human Resource'
        ]);
        $hr->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'HR1']),
            new Remark(['name' => 'Information', 'code' => 'HR2']),
            new Remark(['name' => 'Noting', 'code' => 'HR3']),
        ]);

        $mm = Category::create([
            'name' => 'Material Management'
        ]);
        $mm->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'MM1']),
            new Remark(['name' => 'Information', 'code' => 'MM2']),
            new Remark(['name' => 'Noting', 'code' => 'MM3']),
        ]);

        $cs = Category::create([
            'name' => 'Company Secretariat'
        ]);
        $cs->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'CS1']),
            new Remark(['name' => 'Information', 'code' => 'CS2']),
            new Remark(['name' => 'Noting', 'code' => 'CS3']),
        ]);

        $others = Category::create([
            'name' => 'Others'
        ]);
        $others->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'OT1']),
            new Remark(['name' => 'Information', 'code' => 'OT2']),
        ]);

        $committees = [
            ["name" => "Audit Committee"],
            ["name" => "N&RC Committee"],
            ["name" => "CSR Committee"],
            ["name" => "M&OR Committee"],
            ["name" => "Risk Management Committee"],
            ["name" => "Share Allotment Committee"],
        ];

        Committee::insert($committees);

        $na = Committee::create([
            'name' => 'NA'
        ]);
        $na->id = 0;
        $na->save();
    }
}
