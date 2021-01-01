<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FunctionRuns extends Model
{
    protected $fillable = [
        'user_id',
        'function_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function functions(){
        return $this->belongsTo('App\Functions', 'function_id');
    }
}
