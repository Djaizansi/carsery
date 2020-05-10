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

        $function = new Session();
        if(empty($_SESSION['id'])){
            $myView = new View("login","account");
            $configFormUser = users::getLoginForm();
            $user = new users();

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                //Vérification des champs
                $errors = Validator::checkFormLogin($configFormUser ,$_POST);
                //Insertion ou erreurs
                if(!empty($errors)){
                    $myView->assign('errors',$errors);
                } else {
                    if(!empty($_POST)){
                        $user_found = $user->find('*','email',$_POST['email']);
                        $pwd = $user_found->getPwd();
                        $email = $user_found->getEmail();

                        $pwd_user = isset($pwd) ? $pwd : '';
                        $email_user = isset($email) ? $email : '';

                        $pwd_verif = password_verify($_POST['pwd'],$pwd_user);

                        if($email_user === $_POST['email'] && $pwd_verif){
                            $function->affecterInfosConnecte((int)$user_found->getId());
                            if($function){
                                header("Location: /dashboard");
                            }
                            else{
                                echo "Vous n'êtes pas connecté !";
                            }
                        }else {
                            $errors[] = "Votre mot de passe est incorrect";
                            $myView->assign('errors',$errors);
                        }
                    }
                    else {}
                            
                    }
            }
            $myView->assign("configFormUser", $configFormUser);
        }else {
            header('Location: /dashboard');
        }
    }

    public function forgetAction()
    {   
        $function = new Session();

        if(empty($_SESSION['id'])){
            $myView = new View("forget", "account");
            $configFormUser = users::getMdpForm();
            $user = new users();
            $recup = new recuperation();
            $envoie = new Mail();
            isset($_POST['code']) ? $_POST['code'] : '';

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                //Vérification des champs
                $errors = Validator::checkFormLogin($configFormUser ,$_POST);
                //Insertion ou erreurs
                if(!empty($errors)){
                    $myView->assign('errors',$errors);
                } else {
                    $recup_email = $_POST['email'];

                    $user_found_lastname = $user->find('lastname','email',$recup_email);
                    $user_found_id = $recup->find('id','mail',$recup_email);

                    $nom = isset($user_found_lastname) ? $user_found_lastname->getLastname() : '';
                    $id = isset($user_found_id) ? $user_found_id->getId() : '';

                    $recup_code = "";
                    $_SESSION['email'] = $recup_email;
                    for($i=0; $i < 8; $i++){
                        $recup_code .= mt_rand(0,9);
                    }
                    if(!empty($_POST) && empty($id)){
                        isset($_POST['email']) ? $recup->setMail($_POST['email']) : "";
                        $recup->setCode($recup_code);
                        $recup->setConfirme('0');
                        $recup->save();
                    }else {
                        $recup->setId($id);
                        isset($_POST['email']) ? $recup->setMail($_POST['email']) : "";
                        $recup->setCode($recup_code);
                        $recup->setConfirme('0');
                        $recup->save();
                    }
                    $unMail = ForgetMail::forgetpwd($nom, $recup_code);
                    $unEnvoie = $envoie->sendmail('Récupération mot de passe', $unMail, $recup_email);
                    if($unEnvoie){
                        header('Location: http://localhost/recupcode');
                    }else {
                        echo "Error";
                    }
                }
            }
        $myView->assign("configFormUser", $configFormUser);
    }else{
        header('Location: /dashboard');
    }

        /* $myView->assign("section", $section); */
    }

    public function recupcodeAction() {

        $function = new Session();
        if(!empty($_SESSION['email'])){
            $recup = new recuperation();
            $configFormRecup = recuperation::getCodeForm();
            $myView = new View("recupcode", "account");

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                //Vérification des champs
                $errors = Validator::checkFormLogin($configFormRecup ,$_POST);
                //Insertion ou erreurs
                if(!empty($errors)){
                    $myView->assign('errors',$errors);
                    /* $myView->assign('errors',$errors); */
                } else {
                    if(isset($_POST['code'])){
                        if(!empty($_POST['code'])){
                            $verif_code = htmlspecialchars($_POST['code']);
                            $id_exist_code = $recup->getByAttrubutMultiple('id','mail', $_SESSION['email'], 'code', $verif_code);
                            $id_exist_confirme = $recup->find('id','mail',$_SESSION['email']);

                            $id_exist = $id_exist_confirme->getId();
                            $id_isset_code = $id_exist_code->getId();

                            $id = isset($id_exist) ? $id_exist : '';
                            $id_code = isset($id_isset_code) ? $id_isset_code : '';
                            $donneeCodeConfirme = $recup->find('*','id',$id);

                            if(!empty($id_code)){
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
                }
            $myView->assign("configFormRecup", $configFormRecup);
        }
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

        $confirme = $recup->find('confirme', 'mail', $_SESSION['email']);

        $confirmation = isset($confirme) ? $confirme->getConfirme() : '';

        if($confirmation == 1) {
            $id_exist_user = $user->find('id','email',$_SESSION['email']);
            $id = $id_exist_user->getId();
            
            $unUser = $user->find('*', 'id', $id);

            $unPrenom = $unUser->getFirstname();
            $unNom = $unUser->getLastname();
            $unStatut = $unUser->getStatut();
            $myView = new View("changemdp", "front");

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $errors = Validator::checkFormPwd($configFormPwd ,$_POST);
                //Insertion ou erreurs
                if(!empty($errors)){
                    $myView->assign('errors',$errors);
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
            $myView->assign("configFormPwd", $configFormPwd);
        } else {
            include_once "error/notConnected.php";
        }
    }

    public function registerAction()
    {
        $configFormUser = users::getRegisterForm();
        $user = new users();
        $Session_Start = new Session();
        $myView = new View("register", "account");
        
        if(empty($_SESSION['id'])){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                //Vérification des champs
                $errors = Validator::checkForm($configFormUser ,$_POST);
                //Insertion ou erreurs
                if(!empty($errors)){
                    $myView->assign('errors',$errors);
                    
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
            $myView->assign("configFormUser", $configFormUser); //déclarer un nom d'une variable et mettre dedans. Envoyer des variables aux vues
        }else {
        header('Location: /dashboard');
        }
    }

    public function deconnecterAction(){
        $deconnecter = new Session();
        $deconnecter->deconnecter();
        header("Location: /");
    }
}
