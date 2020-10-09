<?php

namespace App\Jobs;

use App\Mail\MailOtp;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class OtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        // Mail::to($this->user)->send(new MailOtp($this->user));

        $msg = "Your OTP to access Board Portal is " . $this->user->otp . ". This OTP is valid for only 15 minutes";
        $msg = str_replace(" ", "+", $msg);
        $mobile = $this->user->mobile;
        $url = "http://10.205.48.190:13013/cgi-bin/sendsms?username=ongc&password=ongc12&from=ONGC&to=$mobile&text=$msg&charset=UTF-8";

        $client = new Client();
        $client->request('GET', $url);
    }
}
