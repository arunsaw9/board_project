<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function remarks() {
        return $this->hasMany('App\Remark');
    }
}
