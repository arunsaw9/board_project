<?php

use App\Remark;
use App\Category;
use App\Committee;
use Illuminate\Database\Seeder;

class MrplSeeder extends Seeder
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
            new Remark(['name' => 'Noting', 'code' => 'L1']),
        ]);

        $minutes = Category::create([
            'name' => 'Minutes'
        ]);
        $minutes->remarks()->saveMany([
            new Remark(['name' => 'Board', 'code' => 'M1']),
            new Remark(['name' => 'Committee', 'code' => 'M2']),
        ]);

        $directors = Category::create([
            'name' => 'Change in Directors - KMP'
        ]);
        $directors->remarks()->saveMany([
            new Remark(['name' => 'Information', 'code' => 'KMP1']),
            new Remark(['name' => 'Approval', 'code' => 'KMP2']),
            new Remark(['name' => 'Noting', 'code' => 'KMP3']),
            new Remark(['name' => 'Ratification', 'code' => 'KMP4']),
        ]);

        $resolution = Category::create([
            'name' => 'Ratification of resolution'
        ]);
        $resolution->remarks()->saveMany([
            new Remark(['name' => 'Information', 'code' => 'RR1']),
            new Remark(['name' => 'Approval', 'code' => 'RR2']),
            new Remark(['name' => 'Noting', 'code' => 'RR3']),
            new Remark(['name' => 'Ratification', 'code' => 'RR4']),
        ]);

        $finance = Category::create([
            'name' => 'Finance'
        ]);
        $finance->remarks()->saveMany([
            new Remark(['name' => 'Information', 'code' => 'F1']),
            new Remark(['name' => 'Approval', 'code' => 'F2']),
            new Remark(['name' => 'Noting', 'code' => 'F3']),
            new Remark(['name' => 'Ratification', 'code' => 'F4']),
        ]);

        $hr = Category::create([
            'name' => 'Human Resource'
        ]);
        $hr->remarks()->saveMany([
            new Remark(['name' => 'Information', 'code' => 'HR1']),
            new Remark(['name' => 'Approval', 'code' => 'HR2']),
            new Remark(['name' => 'Noting', 'code' => 'HR3']),
            new Remark(['name' => 'Ratification', 'code' => 'HR4']),
        ]);

        $trade = Category::create([
            'name' => 'International Trade'
        ]);
        $trade->remarks()->saveMany([
            new Remark(['name' => 'Information', 'code' => 'IT1']),
            new Remark(['name' => 'Approval', 'code' => 'IT2']),
            new Remark(['name' => 'Noting', 'code' => 'IT3']),
            new Remark(['name' => 'Ratification', 'code' => 'IT4']),
        ]);

        $csr = Category::create([
            'name' => 'CSR'
        ]);
        $csr->remarks()->saveMany([
            new Remark(['name' => 'Information', 'code' => 'CSR1']),
            new Remark(['name' => 'Approval', 'code' => 'CSR2']),
            new Remark(['name' => 'Noting', 'code' => 'CSR3']),
            new Remark(['name' => 'Ratification', 'code' => 'CSR4']),
        ]);

        $ops = Category::create([
            'name' => 'Operations'
        ]);
        $ops->remarks()->saveMany([
            new Remark(['name' => 'Information', 'code' => 'OP1']),
            new Remark(['name' => 'Approval', 'code' => 'OP2']),
            new Remark(['name' => 'Noting', 'code' => 'OP3']),
            new Remark(['name' => 'Ratification', 'code' => 'OP4']),
        ]);

        $refinery = Category::create([
            'name' => 'Refinery'
        ]);
        $refinery->remarks()->saveMany([
            new Remark(['name' => 'Information', 'code' => 'RF1']),
            new Remark(['name' => 'Approval', 'code' => 'RF2']),
            new Remark(['name' => 'Noting', 'code' => 'RF3']),
            new Remark(['name' => 'Ratification', 'code' => 'RF4']),
        ]);

        $mm = Category::create([
            'name' => 'Materials'
        ]);
        $mm->remarks()->saveMany([
            new Remark(['name' => 'Information', 'code' => 'MM1']),
            new Remark(['name' => 'Approval', 'code' => 'MM2']),
            new Remark(['name' => 'Noting', 'code' => 'MM3']),
            new Remark(['name' => 'Ratification', 'code' => 'MM4']),
        ]);

        $cs = Category::create([
            'name' => 'Company Secretariat'
        ]);
        $cs->remarks()->saveMany([
            new Remark(['name' => 'Information', 'code' => 'CS1']),
            new Remark(['name' => 'Approval', 'code' => 'CS2']),
            new Remark(['name' => 'Noting', 'code' => 'CS3']),
            new Remark(['name' => 'Ratification', 'code' => 'CS4']),
        ]);

        $strats = Category::create([
            'name' => 'Corporate Strategy'
        ]);
        $strats->remarks()->saveMany([
            new Remark(['name' => 'Information', 'code' => 'CO1']),
            new Remark(['name' => 'Approval', 'code' => 'CO2']),
            new Remark(['name' => 'Noting', 'code' => 'CO3']),
            new Remark(['name' => 'Ratification', 'code' => 'CO4']),
        ]);

        $subs = Category::create([
            'name' => 'Subsidaries'
        ]);
        $subs->remarks()->saveMany([
            new Remark(['name' => 'Information', 'code' => 'S1']),
            new Remark(['name' => 'Approval', 'code' => 'S2']),
            new Remark(['name' => 'Noting', 'code' => 'S3']),
            new Remark(['name' => 'Ratification', 'code' => 'S4']),
        ]);

        $hse = Category::create([
            'name' => 'HSE'
        ]);
        $hse->remarks()->saveMany([
            new Remark(['name' => 'Information', 'code' => 'HSE1']),
            new Remark(['name' => 'Approval', 'code' => 'HSE2']),
            new Remark(['name' => 'Noting', 'code' => 'HSE3']),
            new Remark(['name' => 'Ratification', 'code' => 'HSE4']),
        ]);

        $committees = [
            ["name" => "Audit Committee"],
            ["name" => "Stakeholders Relationship Committee"],
            ["name" => "CSR&SD Committee"],
            ["name" => "PA&E Committee"],
            ["name" => "NR&HRM Committee"],
            ["name" => "Operations Review Committee"],
            ["name" => "Risk Management Committee"],
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

        $stake = CommitteeMeeting::create([
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

        $pae = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 4
        ]);

        $hrm = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 5
        ]);

        $or = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 6
        ]);

        $rmc = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 7
        ]);

        $cod = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 8
        ]);
    }
}
