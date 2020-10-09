<?php

namespace App\Jobs;

use App\BoardMeeting;
use Illuminate\Bus\Queueable;
use App\Mail\MailNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $users;
    public $message;

    public function __construct($users, $message)
    {
        $this->users = $users;
        $this->message = $message;
    }

    public function handle()
    {
        Mail::to($this->users)->send(new MailNotification($this->message));
    }
}
