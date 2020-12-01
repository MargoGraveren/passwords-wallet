<?php

namespace App\Http\Controllers;

use App\BlockedAccount;
use App\Password;
use App\User;
use App\UserLogins;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class PasswordController extends Controller
{
    //this function allows to control if only registrated and logged users have access to this controller
    public function __construct()
    {
        $this->middleware('auth');
    }
    //returns the main view with the list of passwords
    public function index(){
        var_dump($this->checkIfIPIsBlocked('127.0.0.1'));
        $passwords = Password::latest()->get();
        return view('passwords.index')->with('passwords', $passwords);
    }
    private function checkIfIPIsBlocked($ip){
        $blockedIp = BlockedAccount::where('IP_address', $ip)->first();
        if($blockedIp != null){
            return true;
        }
        else return false;
    }
    //returns the view with decrypted passwords
    public function decryptedIndex(){
        $passwords = Password::latest()->get();
        return view('passwords.index-decrypted')->with('passwords', $passwords);
    }
    //puts hashed password into DB
    public function store(Request $request){
        $request->validate([

        ]);

        $user = Auth::user();
        $password = new Password([
            'password'=>$this->encrypt($request->password, $user->key),
            'web_address'=>$request->web_address,
            'login'=>$request->login,
            'description'=>$request->description,
            'user_id'=>$user->id
        ]);

        $password->save();
        return redirect('/home');
    }
    //this function return the view with creating password
    public function create(){
        return view('passwords.create');
    }

    public function update(){

    }

    public function show(){

    }
    //this is some kind of connector with views - it allows to decrypt showed password, but no one has
    //to the encrypting function's body
    public static function encryptPassword($plaintext, $key){
        if($plaintext == null || $key == null)
            throw new InvalidArgumentException();

        $encrypted = self::encrypt($plaintext, $key);
        return $encrypted;
    }
    //it's the same situation as above
    public static function decryptPassword($ciphertext, $key){
        if($ciphertext == null || $key == null)
            throw new InvalidArgumentException();
        $decrypted = self::decrypt($ciphertext, $key);
        return $decrypted;
    }

    //this function allows to encrypt password
    private static function encrypt($plaintext, $key)
    {
        if($plaintext == null || $key == null)
            throw new InvalidArgumentException();

        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $ciphertext = base64_encode( $iv.$ciphertext_raw );
        return $ciphertext;
    }
    //this function allows to decrypt password
    private static function decrypt($ciphertext, $key)
    {
        if($ciphertext == null || $key == null)
            throw new InvalidArgumentException();

        $c = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $ciphertext_raw = substr($c, $ivlen);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        return $original_plaintext;
    }
}
