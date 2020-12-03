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

class UserLoginsController extends Controller
{

    public function store(Request $request)
    {
        $loginResult = $this->verifyUser($request->email, $request->password);
        $userId = $this->findUserByEmail($request->email)->id;
//        $ipAddress = $request->ip();
        $ipAddress = $request->getHttpHost();

        if ($loginResult == true) {
            $this->storeUserLoginData($request, 'T');
            Auth::login($this->findUserByEmail($request->email));
            return redirect('/home');
        }
        if ($loginResult == false) {
            $this->storeUserLoginData($request, 'F');
            $this->setDelayBasedOnUserFailedLogins($ipAddress, $userId);
            $this->setDelayBasedOnIPsFailedLogins($ipAddress, $userId);
            if ($this->checkIfIPIsBlocked($ipAddress, $userId) == true) {
                return redirect('/login')->with('error', 'Your IP has been blocked!');
            } elseif ($this->checkIfUserIsBlocked($userId) == true) {
                return redirect('/login')->with('error', 'Your account has been blocked!');
            }
//            return redirect('/login')->with('error', $this->countFailedLoginsAmountForUser($userId));
            return redirect('/login')->with('error', 'Failed login data');
        }

    }

    public function verifyUser($email, $password)
    {
        $credentials = array('email' => $email, 'password' => $password);
        $loginResult = Auth::validate($credentials);
        return $loginResult;
    }

    public function findUserByEmail($email)
    {
        $user = User::where('email', $email)->first();
        return $user;
    }

    public function storeUserLoginData($request, $result)
    {
        $userLogin = new UserLogins();

//        $userLogin->IP_address = $request->ip();
        $userLogin->IP_address = $request->getHttpHost();
        $userLogin->login_result = $result;
        $userLogin->user_id = $this->findUserByEmail($request->email)->id;
        $userLogin->save();
    }

    private function countFailedLoginsAmountForIP($ipAddress)
    {
        $userLogins = UserLogins::latest()->get();
        $failedLoginsAmount = 0;
        foreach ($userLogins as $userLogin) {
            if ($userLogin->login_result == 'F' && $userLogin->IP_address == $ipAddress
                && $userLogin->created_at > $this->selectDateOfLastSuccesfullLoginOnCurrentIP($ipAddress)) {
                $failedLoginsAmount += 1;
            }
        }
        return $failedLoginsAmount;
    }

    public function countFailedLoginsAmountForUser($id)
    {
        $userLogins = UserLogins::latest()->get();
        $failedLoginsAmount = 0;
        foreach ($userLogins as $userLogin) {
            if ($userLogin->login_result == 'F' && $userLogin->created_at > $this->selectDateOfLastSuccesfullLogin($id)) {
                $failedLoginsAmount += 1;
            }
        }
        return $failedLoginsAmount;
    }

    private function selectDateOfLastSuccesfullLogin($id)
    {
        $date = DB::table('user_logins')->select(DB::raw('max(created_at)'))->where('login_result',
            'T')->where('user_id', $id)->value('created_at');
        return $date;
    }

    private function selectDateOfLastSuccesfullLoginOnCurrentIP($ipAddress)
    {
        $date = DB::table('user_logins')->select(DB::raw('max(created_at)'))->where('login_result',
            'T')->where('IP_address', $ipAddress)->value('created_at');
        return $date;
    }

    private function setDelayBasedOnUserFailedLogins($ipAddress, $id)
    {
        switch ($this->countFailedLoginsAmountForUser($id)) {
            case 3:
                sleep(5);
                break;
            case 4:
                sleep(10);
                break;
            case 5:
                if ($this->checkIfUserIsBlocked($id) == false && $this->checkIfIPIsBlocked($ipAddress, $id) == false) {
                    $this->blockUser($id);
                    DB::table('blocked_accounts')->where('user_id', $id)->where('created_at',
                        '<=', Carbon::now()->subSeconds(120))->delete();
                }
                break;
        }
    }

    private function setDelayBasedOnIPsFailedLogins($ipAddress, $id)
    {
        switch ($this->countFailedLoginsAmountForIP($ipAddress)) {
            case 3:
                sleep(5);
                break;
            case 4:
                sleep(10);
                break;
            case 5:
                if ($this->checkIfIPIsBlocked($ipAddress, $id) == false) {
                    $this->blockIP($ipAddress, $id);
                }
                break;
        }
    }

    public function blockIP($ipAddress, $id)
    {
        $blockedIP = new BlockedAccount([
            'IP_address' => $ipAddress,
            'user_id' => $id
        ]);
        $blockedIP->save();
    }

    public function blockUser($id)
    {
        $blockedUser = new BlockedAccount([
            'IP_address' => null,
            'user_id' => $id
        ]);
        $blockedUser->save();
    }

    public function checkIfIPIsBlocked($ip, $id)
    {
        $blockedIp = BlockedAccount::where('IP_address', $ip)->where('user_id', $id)->first();
        if ($blockedIp != null) {
            return true;
        } else return false;
    }

    public function checkIfUserIsBlocked($id)
    {
        $blockedUser = BlockedAccount::where('user_id', $id)->where('IP_address', null)->first();
        if ($blockedUser != null) {
            return true;
        } else return false;
    }
}
