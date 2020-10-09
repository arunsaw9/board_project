<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $body;

    public function __construct($message)
    {
        $this->body = $message;
    }

    public function build()
    {
        return $this->subject('AuthCode: 000010')->view('templates.mail');
    }
}
