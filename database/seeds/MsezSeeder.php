<?php

use App\Remark;
use App\Category;
use App\Committee;
use App\BoardMeeting;
use App\CommitteeMeeting;
use Illuminate\Database\Seeder;

class MsezSeeder extends Seeder
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

        $atr = Category::create([
            'name' => 'ATR'
        ]);
        $atr->remarks()->saveMany([
            new Remark(['name' => 'Noting', 'code' => 'ATR1']),
        ]);

        $finance = Category::create([
            'name' => 'Finance'
        ]);
        $finance->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'F1']),
            new Remark(['name' => 'Review | Information', 'code' => 'F2']),
            new Remark(['name' => 'Noting', 'code' => 'F3']),
        ]);

        $op = Category::create([
            'name' => 'Operations'
        ]);
        $op->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'OP1']),
            new Remark(['name' => 'Review | Information', 'code' => 'OP2']),
            new Remark(['name' => 'Noting', 'code' => 'OP3']),
        ]);

        $bd = Category::create([
            'name' => 'Business Development'
        ]);
        $bd->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'BD1']),
            new Remark(['name' => 'Review | Information', 'code' => 'BD2']),
            new Remark(['name' => 'Noting', 'code' => 'BD3']),
        ]);

        $comm = Category::create([
            'name' => 'Commercial'
        ]);
        $comm->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'C1']),
            new Remark(['name' => 'Review | Information', 'code' => 'C2']),
            new Remark(['name' => 'Noting', 'code' => 'C3']),
        ]);

        $hr = Category::create([
            'name' => 'Human Resource'
        ]);
        $hr->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'HR1']),
            new Remark(['name' => 'Review | Information', 'code' => 'HR2']),
            new Remark(['name' => 'Noting', 'code' => 'HR3']),
        ]);

        $it = Category::create([
            'name' => 'Information Technology'
        ]);
        $it->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'IT1']),
            new Remark(['name' => 'Review | Information', 'code' => 'IT2']),
            new Remark(['name' => 'Noting', 'code' => 'IT3']),
        ]);
        
        $cs = Category::create([
            'name' => 'Company Secretariat'
        ]);
        $cs->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'CS1']),
            new Remark(['name' => 'Review | Information', 'code' => 'CS2']),
            new Remark(['name' => 'Noting', 'code' => 'CS3']),
        ]);

        $others = Category::create([
            'name' => 'Others'
        ]);
        $others->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'OT1']),
            new Remark(['name' => 'Review | Information', 'code' => 'OT2']),
            new Remark(['name' => 'Noting', 'code' => 'OT3']),
        ]);

        $committees = [
            ["name" => "Audit Committee"],
            ["name" => "N&RC Committee"],
            ["name" => "CSR Committee"],
            ["name" => "Committee of Directors"],
        ];

        Committee::insert($committees);
        $na = Committee::create([
            'name' => 'NA'
        ]);
        $na->id = 0;
        $na->save();

        $meeting = BoardMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00'
        ]);

        $audit = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 1
        ]);

        $nrc = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 2
        ]);

        $csr = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 3
        ]);

        $cod = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 4
        ]);

    }
}
