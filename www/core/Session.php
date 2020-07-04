<?php 

namespace carsery\core;

use carsery\Managers\UserManager;

session_start();
class Session {

    public function affecterInfosConnecte($id) {
        $_SESSION["id"] = $id;
    }

    public static function estConnecte() {
        return isset($_SESSION["id"]);
    }

    public static function estAdmin() {
        $userManager = new UserManager();
        $foundUser = $userManager->find($_SESSION['id']);
        $role = $foundUser->getStatus();
        if($role === "Admin") return true;
    }

    public function deconnecter() 
    {
        unset($_SESSION["id"]);
        unset($_COOKIE['loader']);
        setcookie("loader", "", time()-3600);
    }
    
}