<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableNames extends Model
{
    public function dataChange(){
        return $this->hasMany('App\DataChange');
    }
}
