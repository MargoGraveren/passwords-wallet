<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Password extends Model
{
    protected $fillable = [
        'id', 'password', 'web_address', 'login', 'description', 'password_type', 'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
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
