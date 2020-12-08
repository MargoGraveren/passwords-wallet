<?php

namespace App\Http\Controllers;

use App\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SharePasswordController extends Controller
{
    public function show($id){
        $password = Password::find($id);
        return view('passwords.share')->with('password', $password);
    }

    public function store(Request $request){
        $user = UserLoginsController::findUserByEmail($request->email);

        $password = new Password([
            'password'=>$request->password,
            'web_address'=>$request->web_address,
            'login'=>$request->login,
            'description'=>$request->description,
            'owner_id'=>Auth::user()->id,
            'user_id'=>$user->id
        ]);

        $password->save();
        return redirect('/home');
    }
}
