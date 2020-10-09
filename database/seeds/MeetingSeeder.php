<?php

use App\User;
use App\BoardMeeting;
use App\CommitteeMeeting;
use Illuminate\Database\Seeder;

class MeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

        $hrm = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 2
        ]);

        $pac = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 3
        ]);

        $fmc = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 4
        ]);

        $csr = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 5
        ]);

        $opal = CommitteeMeeting::create([
            'name' => 1,
            'date' => '2019-01-01',
            'time' => '10:00',
            'committee_id' => 6
        ]);

        // $mrpl = CommitteeMeeting::create([
        //     'name' => 1,
        //     'date' => '2019-01-01',
        //     'time' => '10:00',
        //     'committee_id' => 7
        // ]);

        // $mrpl = CommitteeMeeting::create([
        //     'name' => 1,
        //     'date' => '2019-01-01',
        //     'time' => '10:00',
        //     'committee_id' => 8
        // ]);

        // $users = User::where('role', '!=', 'invitee')->pluck('id');
        // $meeting->users()->sync($users);
    }
}
