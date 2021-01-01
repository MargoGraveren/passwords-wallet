<?php

namespace App\Http\Controllers;

use App\FunctionRuns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index(){
        $activities = FunctionRuns::latest()->get();
        return view('activity.index')->with('activities', $activities);
    }

    public static function registerNewActivity($param){
        $function_id = DB::table('functions')->select('id')->where('function_name',
            $param)->value('id');

        $activity = new FunctionRuns([
            'user_id' => Auth::user()->id,
            'function_id' => $function_id
        ]);
        $activity->save();
    }
}
