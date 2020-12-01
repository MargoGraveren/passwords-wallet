<?php

namespace App\Http\Controllers;

use App\BlockedAccount;
use App\User;
use App\UserLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UserLoginsController extends Controller{

    public function store(Request $request){
        $loginResult = $this->verifyUser($request->email, $request->password);
        $userId = $this->findUserByEmail($request->email)->id;
        $ipAddress = $request->ip();

       if($this->checkIfIPIsBlocked($ipAddress) == true){
           return redirect('/login')->with('error', 'Your IP address has been blocked!');
       }
       else{
           if($loginResult == true){
               $this->storeUserLoginData($request, 'T');
               Auth::login($this->findUserByEmail($request->email));
               return redirect('/home');
           }
           if($loginResult == false){
               $this->setDelayBasedOnIPsFailedLogins($ipAddress, $userId);
               $this->setDelayBasedOnUserFailedLogins($userId, $ipAddress);
               $this->storeUserLoginData($request, 'F');
               return redirect('/login')->with('error', 'Failed login data');
           }
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
            if($userLogin->login_result == 'F' && $userLogin->created_at > $this->selectDateOfLastSuccesfullLogin()
                && $userLogin->id == $id){
                $failedLoginsAmount += 1;
            }
        }

        return $failedLoginsAmount;
    }

    private function selectDateOfLastSuccesfullLogin(){
        $date = DB::table('user_logins')->select(DB::raw('max(created_at)'))->where('login_result',
            'T')->value('created_at');
        return $date;
    }

    private function selectDateOfLastSuccesfullLoginOnCurrentIP($ipAddress){
        $date = DB::table('user_logins')->select(DB::raw('max(created_at)'))->where('login_result',
            'T')->where('IP_address', $ipAddress)->value('created_at');
        return $date;
    }

    private function setDelayBasedOnUserFailedLogins($id, $ipAddress){
        switch ($this->countFailedLoginsAmountForUser($id)){
            case 2:
                sleep(5);
                break;
            case 3:
                sleep(10);
                break;
            case 4:
                if($this->checkIfUserIsBlocked($id) == false){
                    $this->blockUser($id);
                    DB::table('blocked_accounts')->where('user_id', $id)->where('created_at',
                        '<=', Carbon::now()->subSeconds(120))->delete();
                    }
                redirect('/login')->with('error', 'Your account has been blocked for 2 minutes!');
                break;
        }
    }

    private function setDelayBasedOnIPsFailedLogins($ipAddress, $id){
        switch ($this->countFailedLoginsAmountForIP($ipAddress)){
            case 2:
                sleep(5);
                break;
            case 3:
                sleep(10);
                break;
            case 4:
                if($this->checkIfIPIsBlocked($ipAddress) == false){
                    $this->blockIP($ipAddress, $id);
                }
                redirect('/login')->with('error', 'Your IP address has been blocked!');
                break;
        }
    }

    private function blockIP($ipAddress, $id){
        $blockedIP = new BlockedAccount([
            'IP_address' => $ipAddress,
            'user_id'=> $id
        ]);
        $blockedIP->save();
    }

    private function blockUser($id){
        $blockedUser = new BlockedAccount([
            'IP_address'=>null,
            'user_id'=>$id
        ]);
        $blockedUser->save();
    }

    private function checkIfIPIsBlocked($ip){
        $blockedIp = BlockedAccount::where('IP_address', $ip)->first();
        if($blockedIp != null){
            return true;
        }
        else return false;
    }

    private function checkIfUserIsBlocked($id){
        $blockedUser = BlockedAccount::where('user_id', $id)->first();
        if($blockedUser != null){
            return true;
        }
        else return false;
    }
}
