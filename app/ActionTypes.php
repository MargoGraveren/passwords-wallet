<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionTypes extends Model
{
    public function dataChange(){
        return $this->hasMany('App\DataChange');
    }
}
