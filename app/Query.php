<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $guarded = [ ];

    public function raisedBy() {
        return $this->belongsTo('App\User', 'raised_by');
    }
}
