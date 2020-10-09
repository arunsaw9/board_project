<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    public function agendas() {
        return $this->hasMany('App\CommitteeAgenda');
    }

    public function users() {
        return $this->belongsToMany('App\User');
    }

    public function meetings() {
        return $this->hasMany('App\CommitteeMeeting');
    }
}
