<?php

namespace App\Http\Controllers;

use App\DataChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataChangeController extends Controller
{
    public function index(){
        $dataChanges = DataChange::latest()->get();
        return view('activity.changes')->with('dataChanges', $dataChanges);
    }

    public function show($id){
        $details = DataChange::find($id);
        return view('activity.show')->with('details', $details);
    }

    public static function storeChangedData($id, $actionType, $tableName, $previousData, $presentData){
        $change = new DataChange([
            'user_id'=>Auth::id(),
            'modified_record_id'=>$id,
            'previous_value_of_record'=>$previousData,
            'present_value_of_record'=>$presentData,
            'action_type_id'=>self::setActionTypeId($actionType),
            'table_name_id'=>self::setTableNameId($tableName)
        ]);
        $change->save();
        return redirect('/home');
    }

    public static function setActionTypeId($param){
        return DB::table('action_types')->select('id')->where('action_type', $param)->value('id');
    }

    public static function setTableNameId($param){
        return DB::table('table_names')->select('id')->where('table_name', $param)->value('id');
    }

    public static function setPreviousData($password){
        return [
            'password'=>$password->password,
            'web_address'=>$password->web_address,
            'login'=>$password->login,
            'description'=>$password->description,
            'owner_id'=>$password->owner_id,
            'user_id'=>$password->user_id];
    }
}
