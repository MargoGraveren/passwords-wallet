<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataChange extends Model
{
    protected $fillable = [
        'user_id',
        'modified_record_id',
        'previous_value_of_record',
        'present_value_of_record',
        'action_type_id',
        'table_name_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function actionTypes(){
        return $this->belongsTo('App\ActionTypes', 'action_type_id');
    }

    public function tableNames(){
        return $this->belongsTo('App\TableNames', 'table_name_id');
    }
}
