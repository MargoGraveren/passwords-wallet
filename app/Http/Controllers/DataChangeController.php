<?php

namespace App\Http\Controllers;

use App\DataChange;
use App\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataChangeController extends Controller
{
    public function index()
    {
        $dataChanges = DataChange::latest()->get();
        return view('activity.changes')->with('dataChanges', $dataChanges);
    }

    public function show($id)
    {
        $details = DataChange::find($id);
        return view('activity.show')->with('details', $details);
    }

    public static function restoreData($id)
    {
        $dataChange = DataChange::find($id);
        $password = Password::find($dataChange->modified_record_id);

        if ($dataChange->previous_value_of_record != null) {
            $previousData = explode("|", $dataChange->previous_value_of_record);
        } else {
            $previousData = null;
        }

        $presentData = $previousData;

        if ($password == null) {
            self::insertIntoDB($dataChange->tableNames->table_name, $presentData);
        } else {
            self::updateDB($dataChange->tableNames->table_name, $dataChange->modified_record_id, $presentData);
        }

        if ($dataChange->previous_value_of_record == null) {
            DB::table($dataChange->tableNames->table_name)->delete($dataChange->modified_record_id);
        }

        if ($previousData != null)
            $previousData = $dataChange->present_value_of_record;

        if ($presentData != null)
            $password = Password::find($dataChange->modified_record_id);
            $presentData = implode("|", self::setDataArray($password));

        self::storeChangedData($dataChange->modified_record_id, 'recovery', 'passwords',
            $previousData, $presentData);

        return redirect('/home');
    }

    public static function storeChangedData($id, $actionType, $tableName, $previousData, $presentData)
    {
        $change = new DataChange([
            'user_id' => Auth::id(),
            'modified_record_id' => $id,
            'previous_value_of_record' => $previousData,
            'present_value_of_record' => $presentData,
            'action_type_id' => self::setActionTypeId($actionType),
            'table_name_id' => self::setTableNameId($tableName)
        ]);
        $change->save();
    }

    public static function setActionTypeId($param)
    {
        return DB::table('action_types')->select('id')->where('action_type', $param)->value('id');
    }

    public static function setTableNameId($param)
    {
        return DB::table('table_names')->select('id')->where('table_name', $param)->value('id');
    }

    public static function setDataArray($password)
    {
        return [
            'id' => $password->id,
            'password' => $password->password,
            'web_address' => $password->web_address,
            'login' => $password->login,
            'description' => $password->description,
            'owner_id' => $password->owner_id,
            'user_id' => $password->user_id];
    }

    public static function updateDB($tableName, $id, $array)
    {
        if ($array != null) {
            DB::table($tableName)->where('id', $id)->update([
                'password' => $array[1],
                'web_address' => $array[2],
                'login' => $array[3],
                'description' => $array[4],
                'owner_id' => $array[5],
                'user_id' => $array[6]
            ]);
        }
    }

    public static function insertIntoDB($tableName, $array)
    {
        if ($array != null) {
            DB::table($tableName)->insert([
                'id' => $array[0],
                'password' => $array[1],
                'web_address' => $array[2],
                'login' => $array[3],
                'description' => $array[4],
                'owner_id' => $array[5],
                'user_id' => $array[6]]);
        }

    }

    public static function createTemporaryPassword($id)
    {
        return $temp = new Password([
            'id' => $id,
            'password' => null,
            'web_address' => null,
            'login' => null,
            'description' => null,
            'owner_id' => Auth::id(),
            'user_id' => Auth::id()
        ]);
    }
}
