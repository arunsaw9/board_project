<?php

use App\Remark;
use App\Category;
use App\Committee;
use App\BoardMeeting;
use App\CommitteeMeeting;
use Illuminate\Database\Seeder;

class OmplSeeder extends Seeder
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

        $hr = Category::create([
            'name' => 'Human Resource'
        ]);
        $hr->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'HR1']),
            new Remark(['name' => 'Information', 'code' => 'HR2']),
            new Remark(['name' => 'Noting', 'code' => 'HR3']),
        ]);

        $op = Category::create([
            'name' => 'Operations'
        ]);
        $op->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'OP1']),
            new Remark(['name' => 'Information', 'code' => 'OP2']),
            new Remark(['name' => 'Noting', 'code' => 'OP3']),
        ]);

        $marketing = Category::create([
            'name' => 'Marketing'
        ]);
        $marketing->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'MK1']),
            new Remark(['name' => 'Information', 'code' => 'MK2']),
            new Remark(['name' => 'Noting', 'code' => 'MK3']),
        ]);

        $projects = Category::create([
            'name' => 'Projects'
        ]);
        $projects->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'PR1']),
            new Remark(['name' => 'Information', 'code' => 'PR2']),
            new Remark(['name' => 'Noting', 'code' => 'PR3']),
        ]);

        $mm = Category::create([
            'name' => 'Secretarial & Legal'
        ]);
        $mm->remarks()->saveMany([
            new Remark(['name' => 'Approval', 'code' => 'SL1']),
            new Remark(['name' => 'Information', 'code' => 'SL2']),
            new Remark(['name' => 'Noting', 'code' => 'SL3']),
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
            ["name" => "Committee of Directors"],
            ["name" => "N&R Committee"],
            ["name" => "CSR Committee"],
            ["name" => "Empowered Committee of Directors"],
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

        $cod = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 2
        ]);

        $nr = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 3
        ]);

        $csr = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 4
        ]);

        $ecod = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 5
        ]);
    }
}
