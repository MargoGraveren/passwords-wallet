<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ModifyModeController extends Controller
{
    public function index(){
        return view('modifymode');
    }

    public static function switchToTheModifyMode(){
        Cache::put('isInReadMode', false);
        ActivityController::registerNewActivity('modifymode');
        return redirect('/home');
    }

    public static function switchToTheReadMode(){
        Cache::put('isInReadMode', true);
        ActivityController::registerNewActivity('readmode');
        return redirect('/home');
    }
}
