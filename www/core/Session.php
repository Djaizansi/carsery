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
        if($foundUser){
            $role = $foundUser->getStatus();
            if($role === "Admin") return true;
        }else{
            unset($_SESSION['id']);
            $location = Helpers::getUrl('myProject','view');
            header("Location: $location");
        }
    }

    public static function estClient() {
        $userManager = new UserManager();
        $foundUser = $userManager->find($_SESSION['id']);
        if($foundUser){
            $role = $foundUser->getStatus();
            if($role === "Client") return true;
        }else{
            unset($_SESSION['id']);
            $location = Helpers::getUrl('myProject','view');
            header("Location: $location");
        }
    }

    public function deconnecter() 
    {
        unset($_SESSION["id"]);
        unset($_COOKIE['loader']);
        setcookie("loader", "", time()-3600);
    }
    
}