<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Password;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function create()
    {
        return view('auth.main-password-reset');
    }

    public function updatePassword(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $passwords = Password::latest()->get();
        $data=array();

        foreach ($passwords as $password){
            if($password->user_id == $user->id){
                $decrypted = PasswordController::decryptPassword($password->password, $user->key);
                $data[$password->id] = $decrypted;
            }
        }

        if ($request->isPasswordKeptHash == 1) {
            $hash = hash('sha512', $request->password);
            DB::table('users')->where('id', $user->id)->update(['password' => Hash::make($request->password)]);
            DB::table('users')->where('id', $user->id)->update(['key' => $hash]);
        }
        if ($request->isPasswordKeptHash == 0) {
            $hash = hash_hmac('md5', $request->password, 'sabda78r3ha');
            DB::table('users')->where('id', $user->id)->update(['password' => Hash::make($request->password)]);
            DB::table('users')->where('id', $user->id)->update(['key' => $hash]);
        }

        foreach ($passwords as $password){
            if($password->user_id == $user->id){
                $encrypted = PasswordController::encryptPassword($data[$password->id], $hash);
                $password->password = $encrypted;
                $password->save();
            }
        }

        return redirect('/home');
    }

    private function updatePasswordsEncryption($string, $id, $key){
        DB::table('passwords')->where('user_id', $id)->update(['password'=>
            PasswordController::encryptPassword($string,$key)]);
    }
}
