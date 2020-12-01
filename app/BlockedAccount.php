<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlockedAccount extends Model
{
    protected $fillable = [
        'id', 'IP_address', 'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
