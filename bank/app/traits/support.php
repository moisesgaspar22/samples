<?php

namespace bankApp\traits;

/**
 * 🧰⚒️
 * Trait support
 * @package bankApp\traits
 */
trait support
{
    /**
     * @param $sData
     * @param string $action | e = encrypt, d = decrypt
     * @return bool|string
     */
    private static function dataCrypt($sData, $action = 'e')
    {
        /**
         * If for some reason no openssl_encrypt() is available please just uncomment next block
         * encryption is just for demonstration
         */
//        if( $action == 'e' ) {
//            $output = base64_encode( $sData );
//        }
//        else if( $action == 'd' ){
//            $output = base64_decode( $sData );
//        }
//
//        return $output;

        $output         = false;
        $encrypt_method = "AES-256-CBC";
        $key            = hash('sha256', SECRET_KEY);
        $iv             = substr(hash('sha256', SECRET_KEY_IV), 0, 16);

        if ($action == 'e') {
            $output = base64_encode(openssl_encrypt($sData, $encrypt_method, $key, 0, $iv));
        } elseif ($action == 'd') {
            $output = openssl_decrypt(base64_decode($sData), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }
}
