<?php

namespace App\Http\Controllers;

use App\BlockedAccount;
use Illuminate\Http\Request;

class BlockedIpController extends Controller
{
    public function index(){
        $blockedIps = BlockedAccount::latest()->get();
        return view('blocked_ips')->with('blockedIps', $blockedIps);
    }

    public function destroy($id){
        BlockedAccount::where('id', $id)->delete();
        return redirect('/blocked');
    }
}
