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
}
