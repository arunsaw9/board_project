<?php

namespace App\Jobs;

use App\User;
use App\Mail\MailQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class QueryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $query;
    protected $cs;

    public function __construct($query, $cs)
    {
        $this->query = $query;
        $this->cs = $cs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::find($this->cs);
        Mail::to($users)->send(new MailQuery($this->query));
    }
}
