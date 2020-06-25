<?php

namespace carsery\core;

class Helpers
{
    public static function getUrl($controller, $action)
    {
        $routes = yaml_parse_file("router/routes.yml"); // ou yaml_parse_file(../routes.yml);
        if (!empty($routes)) {
            /* $key = array_keys($routes); */
            foreach ($routes as $key => $values) {
                if ($values["controller"]==$controller && $values["action"]==$action) {
                    return $key;
                } else {
                }
            }
        } else {
            die("Le fichier cache n'est pas généré");
        }
    }

    public static function cryptage($pwdchoose){
        $sha256 = '$5$rounds=5000$';
        $charsAuthorized = 'abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ0123456789#@?!*+='; //Permet de prendre des chiffres ou des lettres Maj ou Min
        $charsAuthorized = str_shuffle($charsAuthorized);
        $lengthSha = rand(20,30);
        $pwd = substr($charsAuthorized, 0, $lengthSha);
        $mdpmelange = $sha256.$pwd.'$';
        if(CRYPT_SHA256 == 1){
            return crypt($pwdchoose,$mdpmelange);
        }
    }

    public static function RandomToken($length = 32){
        if(!isset($length) || intval($length) <= 8 ){
            $length = 32;
        }
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }
        if (function_exists('mcrypt_create_iv')) {
            return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
        }
        if (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($length));
        }
    }
    
    public static function Salt($length){
        return substr(strtr(base64_encode(hex2bin(self::RandomToken($length))), '+', '.'), 0, 44);
    }
}
