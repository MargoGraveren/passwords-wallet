<?php

namespace App\Http\Controllers;

use App\FunctionRuns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index()
    {
        if(Cache::get('registeredActivity') == 'all')
        $activities = FunctionRuns::latest()->get();
        else
            $activities = FunctionRuns::where('function_id', self::setFunctionId(Cache::get('registeredActivity')))->get();
        return view('activity.index')->with('activities', $activities);
    }

    public static function registerNewActivity($param)
    {
        $function_id = DB::table('functions')->select('id')->where('function_name',
            $param)->value('id');

        $activity = new FunctionRuns([
            'user_id' => Auth::user()->id,
            'function_id' => $function_id
        ]);
        $activity->save();
    }

    public function putCache($value)
    {
        Cache::put('registeredActivity', $value);
        return redirect('/activity');
    }

    public static function setFunctionId($value){
        return DB::table('functions')->where('function_name', $value)->value('id');
    }
}
