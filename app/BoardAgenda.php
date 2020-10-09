<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BoardAgenda extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    public function meeting() {
        return $this->belongsToMany('App\BoardMeeting');
    }

    public function users() {
        return $this->belongsToMany('App\User');
    }

    public function committee() {
        return $this->belongsTo('App\Committee');
    }
}
