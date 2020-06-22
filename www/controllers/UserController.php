<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Helpers;
use carsery\core\View;
use carsery\core\Session;
use carsery\core\Validator;
use carsery\Managers\RecuperationManager;
use carsery\mail\template\ForgetMail;
use carsery\core\Mail;
use carsery\mail\template\ConfirmAccount;
use carsery\Managers\UserManager;
use carsery\models\Recuperation;
use carsery\models\User;

class UserController
{
    public function gestionUserAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("gestionuser");
        }else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }

    public function loginAction(){
        $function = new Session();
        if(empty($_SESSION['id'])){
            $myView = new View("login","account");
            $configFormUser = UserManager::getLoginForm();
            $userManager = new UserManager();

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                //Vérification des champs
                $errors = Validator::checkFormLogin($configFormUser ,$_POST);
                //Insertion ou erreurs
                if(!empty($errors)){
                    $myView->assign('errors',$errors);
                } else {
                    if(!empty($_POST)){
                        /* $user_found = $user->find('*','email',$_POST['email']); */
                        $user_found = $userManager->findByEmail($_POST['email']);
                        !is_null($user_found) ? $pwd = $user_found->getPwd() : '';
                        !is_null($user_found) ? $email = $user_found->getEmail() : '';

                        $token = $user_found->getToken();
                        $pwd_user = isset($pwd) ? $pwd : '';
                        $email_user = isset($email) ? $email : '';

                        $pwd_verif = password_verify($_POST['pwd'],$pwd_user);

                        if($email_user === $_POST['email'] && $pwd_verif && $token == null){
                            $function->affecterInfosConnecte((int)$user_found->getId());
                            if($function){
                                $location = Helpers::getUrl('Dashboard','dashboard');
                                header("Location: $location");
                            }
                            else{
                                echo "Vous n'êtes pas connecté !";
                            }
                        }elseif(!$pwd_verif) {
                            $errors[] = "Votre mot de passe est incorrect";
                            $myView->assign('errors',$errors);
                        }elseif($token !== null){
                            $errors[] = "Veuillez activer votre compte";
                            $myView->assign('errors',$errors);
                        }
                    }
                    else {}
                            
                    }
            }
            $myView->assign("configFormUser", $configFormUser);
        }else {
            $location = Helpers::getUrl('Dashboard','dashboard');
            header("Location: $location");
        }
    }

    public function forgetAction()
    {   
        $function = new Session();

        if(empty($_SESSION['id'])){
            $myView = new View("forget", "account");
            $configFormUser = UserManager::getMdpForm();
            $userManager = new UserManager();
            $recup = new Recuperation();
            $recupManager = new RecuperationManager();
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

                    $user_found_lastname = $userManager->findByEmail($recup_email);
                    $user_found_id = $recupManager->findByEmail($recup_email);

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
                        $recupManager->save($recup);
                    }else {
                        $recup->setId($id);
                        isset($_POST['email']) ? $recup->setMail($_POST['email']) : "";
                        $recup->setCode($recup_code);
                        $recup->setConfirme('0');
                        $recupManager->save($recup);
                    }
                    $unMail = ForgetMail::forgetpwd($nom, $recup_code);
                    $unEnvoie = $envoie->sendmail('Récupération mot de passe', $unMail, $recup_email);
                    if($unEnvoie){
                        $location = Helpers::getUrl('User','recupcode');
                        header("Location: $location");
                    }else {
                        throw new RouteException("Un problème est survenue lors de l'envoie de mail");
                    }
                }
            }
        $myView->assign("configFormUser", $configFormUser);
    }else{
        $location = Helpers::getUrl('Dashboard','dashboard');
        header("Location: $location");
    }

        /* $myView->assign("section", $section); */
    }

    public function recupcodeAction() {

        $function = new Session();
        if(!empty($_SESSION['email'])){
            $recupManager = new RecuperationManager();
            $recup = new Recuperation();
            $configFormRecup = RecuperationManager::getCodeForm();
            $myView = new View("recupcode", "account");
            $myView->assign("configFormRecup", $configFormRecup);

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
                            $id_exist_code = $recupManager->findBy(['mail' => $_SESSION['email'], 'code' => $verif_code])[0];
                            
                            $id_exist_confirme = $recupManager->findByEmail($_SESSION['email']);

                            $id_isset_code = $id_exist_code->getId();
                            $id_exist = $id_exist_confirme->getId();

                            $id = isset($id_exist) ? $id_exist : '';
                            $id_code = isset($id_isset_code) ? $id_isset_code : '';
                            $donneeCodeConfirme = $recupManager->findById($id);

                            if(!empty($id_code)){
                                if(!empty($id_exist_confirme)){
                                    $unId = $donneeCodeConfirme->getId();
                                    $unMail = $donneeCodeConfirme->getMail();
                                    $unCode = $donneeCodeConfirme->getCode();
                                            
                                    $recup->setId($unId);
                                    $recup->setMail($unMail);
                                    $recup->setCode($unCode);
                                    $recup->setConfirme('1');
                                    $recupManager->save($recup);

                                    $location = Helpers::getUrl('User','changemdp');
                                    header("Location: $location");
                                }
                            }else {
                                    echo "Le code ne fonctionne pas";
                            }
                        }
                    }
                }
            }
    }else{
        throw new RouteException("Vous devez renseigner votre email pour accèder à cette page");
    }
    }

    public function changemdpAction() {
        $configFormPwd = RecuperationManager::getPwdForm();
        $userManager = new UserManager();
        $user = new User();
        $function = new Session();
        $recup = new RecuperationManager();
        $_SESSION['email'] = isset($_SESSION['email']) ? $_SESSION['email'] : '';

        $confirme = $recup->findByEmail($_SESSION['email']);

        $confirmation = isset($confirme) ? $confirme->getConfirme() : '';

        if($confirmation == 1) {
            $id_exist_user = $userManager->findByEmail($_SESSION['email']);/* 'id','email',$_SESSION['email']); */
            $id = $id_exist_user->getId();
            
            $unUser = $userManager->findById($id);
            $unPrenom = $unUser->getFirstname();
            $unNom = $unUser->getLastname();
            $unStatut = $unUser->getStatus();
            $myView = new View("changemdp", "account");

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
                        $user->setToken(null);
                        $userManager->save($user);
                        $location = Helpers::getUrl('User','login');
                        header("Location: $location");
                        $del = $recup->delete('mail',$_SESSION['email']);
                        session_destroy();
                    }
                }
            }
            $myView->assign("configFormPwd", $configFormPwd);
        } else {
            throw new RouteException("Vous devez valider votre code de confirmation");
        }
    }

    public function registerAction()
    {
        $configFormUser = UserManager::getRegisterForm();
        $token = Helpers::Salt(20);
        $userManager = new UserManager();
        $user = new User();
        $Session_Start = new Session();
        $envoie = new Mail();
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
                        $user->setToken($token);
                        $userManager->save($user);
                        $unMail = ConfirmAccount::mailConfirm($_POST['lastname'],$_POST['email']);
                        $unEnvoie = $envoie->sendmail('Confirmation de compte', $unMail, $_POST['email']);
                        if($unEnvoie){
                            $success = 1;
                            $_SESSION['success'] = $success;
                            $location = Helpers::getUrl('User','login');
                            header("Location: $location");
                        }else {
                            throw new RouteException("Un problème est survenue lors de l'envoie de mail");
                        }
                    }
                }
            }
            $myView->assign("configFormUser", $configFormUser); //déclarer un nom d'une variable et mettre dedans. Envoyer des variables aux vues
        }else {
            $location = Helpers::getUrl('Dashboard','dashboard');
            header("Location: $location");
        }
    }

    public function confirmAccountAction(){
        $userManager = new UserManager();
        $user = new User();
        if(isset($_GET['id']) && isset($_GET['token'])){
            $found = $userManager->find($_GET['id']);
            $token = isset($found) ? $found->getToken() : '';
            $id = isset($found) ? $found->getId() : '';
            if($id === $_GET['id'] && $token === $_GET['token']){
                $myView = new View('confirmAccount','account');
                $myView->assign('found',$found);
                $user->setId((int)$id);
                $user->setLastname($found->getLastname());
                $user->setFirstname($found->getFirstname());
                $user->setEmail($found->getEmail());
                $user->setPwd($found->getPwd());
                $user->setStatus($found->getStatus());
                $user->setToken(null);
                $userManager->save($user);
            }elseif($token === null){
                $location = Helpers::getUrl('User','login');
                header("Location: $location");
            }elseif($id !== $_GET['id'] && $token !== $_GET['token']){
                throw new RouteException("Le lien n'est pas valide");
            }
        }else{
            throw new RouteException("Vous n'avez pas accès à cette page");
        }
    }

    public function deconnecterAction(){
        $deconnecter = new Session();
        $deconnecter->deconnecter();
        $location = Helpers::getUrl('User','login');
        header("Location: $location");
    }
}
