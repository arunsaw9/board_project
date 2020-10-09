<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailQuery extends Mailable
{
    use Queueable, SerializesModels;

    public $query;
    public $user;
    
    public function __construct($query)
    {
        $this->query = $query;
        $this->user = Auth::user()->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('templates.query');
    }
}
