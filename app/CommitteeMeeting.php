<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CommitteeMeeting extends Model implements Auditable
{
    protected $guarded = [];

    use \OwenIt\Auditing\Auditable;

    public function committee() {
        return $this->belongsTo('App\Committee');
    }

    public function agendas() {
        return $this->belongsToMany('App\CommitteeAgenda');
    }

    public function users() {
        return $this->belongsToMany('App\User');
    }
}
