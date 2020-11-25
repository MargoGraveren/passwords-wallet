<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLogins extends Model
{
    protected $fillable = [
      'IP_address', 'login_result', 'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
