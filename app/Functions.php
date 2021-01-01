<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Functions extends Model
{
    public function functionRuns(){
        return $this->hasMany('App\FunctionRuns');
    }
}
