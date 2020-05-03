<?php

namespace controllers;

class UserController
{
    public function gestionUserAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("gestionuser");
        }
    }

    public function loginAction(){
        $myView = new View("login","account");
        $function = new Session();
        $user = new users();
        if(!empty($_POST)){
            $donnee = [];
            $utilisateur = $user->login($_POST['email'], $_POST['mdp']);
            if (is_array($utilisateur) || is_object($utilisateur)){
                foreach ($utilisateur as $users){
                    $donnee[] = $users;
                }
                $function->affecterInfosConnecte((int) $donnee[0]);
                
                if($function){
                    echo "Vous êtes connecté !";
                    header("Location: /dashboard");
                }
                else{
                    echo "Vous n'êtes pas connecté !";
                }
            }
        }
        else {}
    }

    public function forgetAction()
    {
        $myView = new View("forget", "account");
    }

    public function registerAction()
    {
        $configFormUser = users::getRegisterForm();
        $user = new users();

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Vérification des champs
            $errors = Validator::checkForm($configFormUser ,$_POST);
            //Insertion ou erreurs
            if(!empty($errors)){
                print_r($errors);
            } else {
                if(!empty($_POST)){
                    isset($_POST['lastname']) ? $user->setLastname($_POST['lastname']) : "";
                    isset($_POST['firstname']) ? $user->setFirstname($_POST['firstname']) : "";
                    isset($_POST['email']) ? $user->setEmail($_POST['email']) : "";
                    isset($_POST['pwd']) ? $user->setPwd($_POST['pwd']) : "";
                    $user->setStatus('Client');
                    $user->save();
                }
            }
        }
        print_r($_POST);
        $myView = new View("register", "account");
        $myView->assign("configFormUser", $configFormUser); //déclarer un nom d'une variable et mettre dedans. Envoyer des variables aux vues

    }

    public function deconnecterAction(){
        $deconnecter = new Session();
        $deconnecter->deconnecter();
        header("Location: /");
    }
}
