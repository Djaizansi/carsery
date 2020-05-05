<?php

namespace carsery\controllers;

use carsery\core\Helpers;
use carsery\core\View;
use carsery\core\Session;
use carsery\models\users;
use carsery\core\Validator;
use carsery\models\recuperation;
use carsery\mail\template\ForgetMail;
use carsery\core\Mail;

class UserController
{
    public function gestionUserAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("gestionuser");
        }else {
            include_once "./error/notConnected.php";
        }
    }

    public function loginAction(){

        $configFormUser = users::getLoginForm();
        $user = new users();
        $function = new Session();

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Vérification des champs
            $errors = Validator::checkFormLogin($configFormUser ,$_POST);
            //Insertion ou erreurs
            if(!empty($errors)){
                print_r($errors);
            } else {
                if(!empty($_POST)){
                    $id_user = $user->getByAttribut('id','email',$_POST['email'])['id'];
                    $user_found = $user->find($id_user);
                    $pwd_user = $user_found->getPwd();
                    $email_user = $user_found->getEmail();
                    $pwd_verif = password_verify($_POST['pwd'],$pwd_user);

                    if($email_user === $_POST['email'] && $pwd_verif){
                        $function->affecterInfosConnecte((int)$user_found->getId());
                        if($function){
                            header("Location: /dashboard");
                        }
                        else{
                            echo "Vous n'êtes pas connecté !";
                        }
                    }
                }
                else {}
                        
                }
        }
        $myView = new View("login","account");
        $myView->assign("configFormUser", $configFormUser);
    }

    public function forgetAction()
    {   
        $configFormUser = users::getMdpForm();
        $user = new users();
        $recup = new recuperation();
        $envoie = new Mail();
        $section = isset($_GET['section']) ? htmlspecialchars($_GET['section']) : '';
        $function = new Session();
        isset($_POST['code']) ? $_POST['code'] : '';

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Vérification des champs
            $errors = Validator::checkFormLogin($configFormUser ,$_POST);
            //Insertion ou erreurs
            if(!empty($errors)){
                print_r($errors);
            } else {
                $recup_email = $_POST['email'];
                $prenom = $user->getByAttribut('firstname','email',$recup_email)["firstname"];
                $id_exist = $recup->getByAttribut('id','mail',$recup_email)['id'];
                $recup_code = "";
                $_SESSION['email'] = $recup_email;
                for($i=0; $i < 8; $i++){
                    $recup_code .= mt_rand(0,9);
                }
                if(!empty($_POST) && empty($id_exist)){
                    isset($_POST['email']) ? $recup->setMail($_POST['email']) : "";
                    $recup->setCode($recup_code);
                    $recup->setConfirme('0');
                    $recup->save();
                }else {
                    $recup->setId($id_exist);
                    isset($_POST['email']) ? $recup->setMail($_POST['email']) : "";
                    $recup->setCode($recup_code);
                    $recup->setConfirme('0');
                    $recup->save();
                }
                $unMail = ForgetMail::forgetpwd($prenom, $recup_code);
                $unEnvoie = $envoie->sendmail('Récupération mot de passe', $unMail, $recup_email);
                if($unEnvoie){
                    header('Location: http://localhost/recupcode');
                }else {
                    echo "Error";
                }
            }
        }

        $myView = new View("forget", "account");
        $myView->assign("configFormUser", $configFormUser);
        /* $myView->assign("section", $section); */
    }

    public function recupcodeAction() {

        $function = new Session();
        if(!empty($_SESSION['email'])){
            $recup = new recuperation();
            $configFormRecup = recuperation::getCodeForm();
            if(isset($_POST['code'])){
                
                if(!empty($_POST['code'])){
                    $verif_code = htmlspecialchars($_POST['code']);
                    $id_exist_code = $recup->getByAttrubutMultiple('id','mail', $_SESSION['email'], 'code', $verif_code)['id'];
                    $id_exist_confirme = $recup->getByAttribut('id','mail',$_SESSION['email'])['id'];
                    $donneeCodeConfirme = $recup->find($id_exist_confirme);
                    var_dump($donneeCodeConfirme);
                    if(!empty($id_exist_code)){
                        if(!empty($id_exist_confirme)){
                            $unId = $donneeCodeConfirme->getId();
                            $unMail = $donneeCodeConfirme->getMail();
                            $unCode = $donneeCodeConfirme->getCode();
                            
                            $recup->setId($unId);
                            $recup->setMail($unMail);
                            $recup->setCode($unCode);
                            $recup->setConfirme('1');
                            $recup->save();

                            header('Location: http://localhost/changemdp');
                        }
                    }else {
                        echo "Le code ne fonctionne pas";
                    }
                }
            }
            $myView = new View("recupcode", "account");
            $myView->assign("configFormRecup", $configFormRecup);
        }else{
            include_once "error/404.php";
        }
    }

    public function changemdpAction() {
        $configFormPwd = recuperation::getPwdForm();
        $user = new users();
        $function = new Session();
        $recup = new recuperation();
        $_SESSION['email'] = isset($_SESSION['email']) ? $_SESSION['email'] : '';

        $confirme = $recup->getByAttribut('confirme', 'mail', $_SESSION['email'])['confirme'];

        if($confirme == 1) {
            $id_exist_user = $user->getByAttribut('id','email',$_SESSION['email'])['id'];
            $unUser = $user->find($id_exist_user);
            $unPrenom = $unUser->getFirstname();
            $unNom = $unUser->getLastname();
            $unStatut = $unUser->getStatus();

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $errors = Validator::checkFormPwd($configFormPwd ,$_POST);
                //Insertion ou erreurs
                if(!empty($errors)){
                    print_r($errors);
                }else {
                    if(!empty($_POST)){
                        $user->setId((int)$id_exist_user);
                        $user->setLastname($unNom);
                        $user->setFirstname($unPrenom);
                        $user->setEmail($_SESSION['email']);
                        isset($_POST['pwd']) ? $user->setPwd(Helpers::cryptage($_POST['pwd'])) : "";
                        $user->setStatus($unStatut);
                        $user->save();
                        header("Location: /");
                        $del = $recup->delete('mail',$_SESSION['email']);
                        session_destroy();
                    }
                }
            }

            $myView = new View("changemdp", "account");
            $myView->assign("configFormPwd", $configFormPwd);
        } else {
            include_once "error/404.php";
        }
    }

    public function registerAction()
    {
        $configFormUser = users::getRegisterForm();
        $user = new users();
        $Session_Start = new Session();
        

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
                    isset($_POST['pwd']) ? $user->setPwd(Helpers::cryptage($_POST['pwd'])) : "";
                    $user->setStatus('Client');
                    $user->save();
                    header("Location: /");
                }
            }
        }
        $myView = new View("register", "account");
        $myView->assign("configFormUser", $configFormUser); //déclarer un nom d'une variable et mettre dedans. Envoyer des variables aux vues
    }

    public function deconnecterAction(){
        $deconnecter = new Session();
        $deconnecter->deconnecter();
        header("Location: /");
    }
}
