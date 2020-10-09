<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BoardMeeting extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $guarded = [];

    public function agendas() {
        return $this->belongsToMany('App\BoardAgenda');
    }

    public function users() {
        return $this->belongsToMany('App\User');
    }
}
