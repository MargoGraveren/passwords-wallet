<?php

namespace App\Http\Controllers;

use App\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $passwords = Password::latest()->get();
        ActivityController::registerNewActivity('read');
        return view('passwords.index')->with('passwords', $passwords);
    }

    //returns the view with decrypted passwords
    public function decryptedIndex(){
        $passwords = Password::latest()->get();
        return view('passwords.index-decrypted')->with('passwords', $passwords);
    }

    //puts hashed password into DB
    public function store(Request $request){
        ActivityController::registerNewActivity('create');
        $password = new Password([
            'password'=>$this->encrypt($request->password, Auth::user()->key),
            'web_address'=>$request->web_address,
            'login'=>$request->login,
            'description'=>$request->description,
            'owner_id'=>Auth::id(),
            'user_id'=>Auth::id()
        ]);

        $password->save();

        return redirect('/home');
    }

    //this function return the view with creating password
    public function create(){
        return view('passwords.create');
    }

    public function edit($id){
        ActivityController::registerNewActivity('update');
        $password = Password::find($id);
        return view('passwords.edit')->with('password', $password);
    }

    public function show(){

    }

    public function update(Request $request, $id){
        $password = Password::find($id);
        $previousData = DataChangeController::setDataArray($password);

        $presentData = [
            'id'=>$id,
            'password'=>$this->encrypt($request->password, Auth::user()->key),
            'web_address'=>$request->web_address,
            'login'=>$request->login,
            'description'=>$request->description,
            'owner_id'=>Auth::id(),
            'user_id'=>Auth::id()];

        DataChangeController::storeChangedData($password->id, 'update', 'passwords',
            implode("|", $previousData), implode("|", $presentData));

        $password->update($presentData);
        return redirect('/home');
    }

    public function destroy($id){
        ActivityController::registerNewActivity('delete');
        $password = Password::find($id);
        $previousData = DataChangeController::setDataArray($password);
        DataChangeController::storeChangedData($password->id, 'delete', 'passwords',
            implode("|", $previousData), null);
        Password::where('id', $id)->delete();
        return redirect('/home');
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
    public static function encrypt($plaintext, $key)
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
