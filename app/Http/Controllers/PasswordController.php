<?php

namespace App\Http\Controllers;

use App\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Generator\StringManipulation\Pass\Pass;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
//        $user=Auth::user();
//        $this->decrypt(Auth::user()->password()->first(), Auth::user()->key);
//        var_dump($this->decryptPassword(Auth::user()->password()->first()->password, Auth::user()->key));

        $passwords = Password::latest()->get();
        return view('passwords.index')->with('passwords', $passwords);
    }

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

    public function create(){
        return view('passwords.create');
    }

    public function update(){

    }

    public function show(){

    }

    public static function encryptPassword($plaintext, $key){
        $encrypted = self::encrypt($plaintext, $key);
        return $encrypted;
    }

    public static function decryptPassword($ciphertext, $key){
        $decrypted = self::decrypt($ciphertext, $key);
        return $decrypted;
    }

    private static function encrypt($plaintext, $key)
    {
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $ciphertext = base64_encode( $iv.$ciphertext_raw );
        return $ciphertext;
    }

    private static function decrypt($ciphertext, $key)
    {
        $c = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $ciphertext_raw = substr($c, $ivlen);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        return $original_plaintext;
    }
}
