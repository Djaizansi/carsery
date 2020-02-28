<?php

class UserController
{
    public function gestionUserAction() 
    {
        $myView = new View("gestionuser");
    }

    public function loginAction()
    {
        $myView = new View("login", "account");
    }

    public function forgetAction()
    {
        $myView = new View("forget", "account");
    }

    public function registerAction()
    {
        $configFormUser = user::getRegisterForm();

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Vérification des champs
            $errors = Validator::checkForm($configFormUser ,$_POST);
            //Insertion ou erreurs
            print_r($errors);
        }

        $myView = new View("register", "account");
        $myView->assign("configFormUser", $configFormUser); //déclarer un nom d'une variable et mettre dedans. Envoyer des variables aux vues
    }
}
