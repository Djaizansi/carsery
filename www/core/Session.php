<?php 

namespace core;

session_start();
class Session {

    public function affecterInfosConnecte($id) {
        $_SESSION["id"] = $id;
    }

    public static function estConnecte() {
        return isset($_SESSION["id"]);
    }

    public function deconnecter() 
    {
        unset($_SESSION["id"]);
        unset($_COOKIE['loader']);
        setcookie("loader", "", time()-3600);
    }
    
}