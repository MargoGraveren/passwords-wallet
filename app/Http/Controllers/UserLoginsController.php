<?php

namespace App\Http\Controllers;

use App\User;
use App\UserLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserLoginsController extends Controller{

    public function store(Request $request){
        $loginResult = $this->verifyUser($request->email, $request->password);

        if($loginResult == true){
            $this->storeUserLoginData($request, 'T');
            Auth::login($this->findUserByEmail($request->email));
            return redirect('/home');
        }
        if($loginResult == false){
            $this->storeUserLoginData($request, 'F');
            return redirect('/login');
        }
    }

    private function verifyUser($email, $password){
        $credentials = array('email'=>$email, 'password'=>$password);
        $loginResult = Auth::validate($credentials);

        return $loginResult;
    }

    private function findUserByEmail($email){
        $user = User::where('email', $email)->first();
        return $user;
    }

    private function storeUserLoginData($request, $result){
        $userLogin = new UserLogins();

        $userLogin->IP_address = $request->ip();
        $userLogin->login_result = $result;
        $userLogin->user_id = $this->findUserByEmail($request->email)->id;
        $userLogin->save();
    }

    private function countFailedLoginsAmountForIP($ipAddress){
        $userLogins = UserLogins::latest()->get();
        $failedLoginsAmount = 0;
        foreach ($userLogins as $userLogin){
            if($userLogin->login_result == 'F' && $userLogin->IP_address == $ipAddress
                && $userLogin->created_at > $this->selectDateOfLastSuccesfullLoginOnCurrentIP($ipAddress)){
                $failedLoginsAmount += 1;
            }
        }
        return $failedLoginsAmount;
    }

    private function countFailedLoginsAmountForUser($id){
        $userLogins = UserLogins::latest()->get();
        $failedLoginsAmount = 0;
        foreach ($userLogins as $userLogin ){
            if($userLogin->login_result == 'F' && $userLogin->created_at > $this->selectDateOfLastSuccesfullLogin()){
                $failedLoginsAmount += 1;
            }
        }

        return $failedLoginsAmount;
    }

    private function selectDateOfLastSuccesfullLogin(){
        $date = DB::table('user_logins')->select(DB::raw('max(created_at)'))->where('login_result', 'T')->value('created_at');
        return $date;
    }

    private function selectDateOfLastSuccesfullLoginOnCurrentIP($ipAddress){
        $date = DB::table('user_logins')->select(DB::raw('max(created_at)'))->where('login_result', 'T')->where('IP_address', $ipAddress)->value('created_at');
        return $date;
    }
}
