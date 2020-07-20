<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Helpers;
use carsery\core\View;
use carsery\core\Session;
use carsery\core\Validator;
use carsery\models\Page;
use carsery\Managers\PageManager;
use carsery\Managers\ShortCodeManager;
use carsery\Managers\UserManager;
use carsery\models\Json;
use carsery\models\Shortcode;


define('CONFIGUPDATETITLE', PageManager::getUpdateTitleForm());

class PageController
{

    public function jsonAction()
    {
        $userManager = new UserManager();
        $user = $userManager->find(1)->__toArray();
        $json = new Json($user);
        echo json_encode($json, JSON_PRETTY_PRINT);
    }

    public function pageAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $pageManager = new PageManager();
            $myView = new View("page");
            $myView->assign('pageManager', $pageManager);
            $configFormPage = PageManager::getPageForm();
            if(!empty($_POST)){
                $errors = Validator::checkForm(CONFIGUPDATETITLE ,$_POST);
                $myView->assign('errors', $errors);
            }
            $myView->assign('configFormTitle', CONFIGUPDATETITLE);
            $myView->assign('configFormPage', $configFormPage);
        } else {
            throw new RouteException("Vous devez être connecté");
        }
    }

    public function deletePageAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $pageManager = new PageManager();
            $page = new Page();
            $pageFound = $pageManager->find($_GET['id']);

            if (!isset($pageFound)) {
                throw new RouteException("La page que vous voulez supprimer n'existe pas ou plus");
            } else {
                $token = $pageFound->getToken();


                if (isset($_GET['id']) /* && isset($_GET['token']) && $token == $_GET['token'] */) {
                    $pageManager->delete('id', $_GET['id']);
                    $location = Helpers::getUrl('Page', 'page');
                    header("Location: $location");
                } else {
                    throw new RouteException("Vous pouvez pas supprimer d'autre page aussi facilement");
                }
            }
        } else {
            throw new RouteException("Vous devez être connecté");
        }
    }

    public function addPageAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $token = Helpers::Salt(20);
            $page = new Page();
            $pageManager = new PageManager();
            $userManager = new UserManager();

            $findUser = $userManager->find($_SESSION['id']);
            $prenom = $findUser->getFirstname();
            $titre_tiret = '/myproject/' . str_replace(' ', '-', strtolower(htmlspecialchars($_POST['titre'])));
            $pageExist = $pageManager->findByUri($titre_tiret);
            $findAll = $pageManager->findAll();
            foreach ($findAll as $myPage) {
                if ($myPage->getHome() == 1) {
                    $homeExist = 1;
                } elseif ($myPage->getTemplate() == 0) {
                    $template = 0;
                } elseif ($myPage->getTemplate() == 1) {
                    $template = 1;
                }
            }
            if (!empty($_POST)) {
                if ($pageExist) {
                    throw new RouteException("La page que vous voulez ajouter existe déjà");
                } else {
                    if (!isset($_POST['public']) && isset($_POST['checkbox'])) {
                        $_SESSION['menu'] = 'erreurmenu';
                        $location = Helpers::getUrl('Page', 'page');
                        header("Location: $location");
                    } elseif ($homeExist == 1 && isset($_POST['home'])) {
                        $_SESSION['menu'] = 'erreurmenu';
                        $location = Helpers::getUrl('Page', 'page');
                        header("Location: $location");
                    } else {
                        $home = isset($_POST['home']) ? 1 : 0;
                        $unPublic = isset($_POST['public']) ? 1 : 0;
                        $unMenu = isset($_POST['checkbox']) ? 1 : 0;
                        if (empty($_SESSION['menu'])) {
                            PageManager::addData($page, $pageManager, '', htmlspecialchars($_POST['titre']), $prenom, 'Hello', '', $unPublic, $titre_tiret, $unMenu, $home, $template, $token);
                            $location = Helpers::getUrl('Page', 'page');
                            header("Location: $location");
                        }
                    }
                }
            }
        } else {
            throw new RouteException("Vous devez être connecter pour accèder à cette page");
        }
    }

    public function modifierPageAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $token = Helpers::Salt(20);
            $pageManager = new PageManager();
            $page = new Page();
            $shortCodeManager = new ShortCodeManager();
            $findAllShort = $shortCodeManager->findAll();
            $configFormPage = PageManager::getWYSIWYGForm();
            $find = $pageManager->findAll();
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $unePage = $pageManager->find($_GET['id']);
                if(!is_null($unePage)){
                    $auteur = $unePage->getAuteur();
                    $uri = $unePage->getUri();
                    $date = $unePage->getDate();
                    $titre = htmlspecialchars($unePage->getTitre());
                    $template = $unePage->getTemplate();

                    $myView = new View("editpage");
                    $myView->assign('pageManager', $pageManager);
                    $myView->assign('configFormPage', $configFormPage);
                    $myView->assign('findAllShort',$findAllShort);
                    foreach ($find as $myPage) {
                        if ($myPage->getHome() == 1) {
                            $homeExist = 1;
                        }
                    }
                    if (!empty($_POST)) {
                        isset($_POST['editPage']) ? $_POST['editPage'] : '';
                        $home = isset($_POST['home']) ? 1 : 0;

                        if (!isset($_POST['public']) && isset($_POST['checkbox'])) {
                            $errors[] = "Vous ne pouvez pas mettre votre page dans le menu <br> Astuce : Vous devez publier votre page avant de pouvoir la mettre en menu";
                            $myView->assign('errors', $errors);
                        } elseif (!isset($_POST['public'])) {
                            $unPublic = 0;
                            $unMenu = 0;
                            if ($unePage->getHome() == 0 && $homeExist == 1 && isset($_POST['home'])) {
                                $errors[] = "Une page home existe déjà";
                                $myView->assign('errors', $errors);
                            } elseif (empty($errors)) {
                                PageManager::addData($page, $pageManager, $_GET['id'], $titre, $auteur, $_POST['editPage'], $date, $unPublic, $uri, $unMenu, $home, $template, $token);
                                $location = Helpers::getUrl('Page', 'page');
                                header("Location: $location");
                            }
                        } elseif (isset($_POST['public'])) {
                            $unPublic = 1;
                            $unMenu = isset($_POST['checkbox']) ? 1 : 0;
                            if ($unePage->getHome() == 0 && $homeExist == 1 && isset($_POST['home'])) {
                                $errors[] = "Une page home existe déjà";
                                $myView->assign('errors', $errors);
                            } elseif (empty($errors)) {
                                PageManager::addData($page, $pageManager, $_GET['id'], $titre, $auteur, $_POST['editPage'], $date, $unPublic, $uri, $unMenu, $home, $template, $token);
                                $location = Helpers::getUrl('Page', 'page');
                                header("Location: $location");
                            }
                        }
                    }
                } elseif(is_null($unePage)){
                    throw new RouteException("La page n'existe pas");
                }
            }
            elseif (!isset($_GET['id']) || empty($_GET['id'])) {
                throw new RouteException("La modification n'est pas disponible ");
            }
        } else {
            throw new RouteException("Vous devez être connecter pour accèder à cette page");
        }
    }

    public function modifTitleAction(){

        if(Session::estConnecte() && Session::estAdmin()){
            $pageManager = new PageManager();
            $page = new Page();
            $token = Helpers::Salt(20);
            $unePage = $pageManager->find($_POST['id']);

            if(!empty($_POST)){
                $errors = Validator::checkForm(CONFIGUPDATETITLE ,$_POST);
            }

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(!empty($_POST)){
                    if(!empty($errors)){
                        return $this->pageAction();
                    }else{
                        $auteur = $unePage->getAuteur();
                        $uri = '/myproject/' . str_replace(' ', '-', strtolower(htmlspecialchars($_POST['untitre'])));
                        $date = $unePage->getDate();
                        $content = $unePage->getContent();
                        $template = $unePage->getTemplate();
                        $unPublic = $unePage->getPublie();
                        $unMenu = $unePage->getMenu();
                        $home = $unePage->getHome();
                        PageManager::addData($page, $pageManager, $_POST['id'], htmlspecialchars($_POST['untitre']), $auteur, $content, $date, $unPublic, $uri, $unMenu, $home, $template, $token);
                        $_SESSION['success'] = "updateTitre";
                        $location = Helpers::getUrl('Page','page');
                        header("Location: $location");
                    }
                }
            }
        }else{
            throw new RouteException("Vous n'avez pas le droit à cette action");
        }
    }

    public function widgetPageAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $myView = new View("widget");
            $pageManager = new PageManager();
            $shortCodeManager = new ShortCodeManager();
            $shortCode = new Shortcode();
            $myView->assign('shortCodeManager', $shortCodeManager);
            $myView->assign('shortCode', $shortCode);
            $myView->assign('pageManager', $pageManager);
        } else {
            throw new RouteException("Vous devez être connecter pour accèder à cette page");
        }
    }

    public function updateTemplateAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $pageManager = new PageManager();
            $foundAll = $pageManager->findAll();
            if (isset($_POST['template'])) {
                foreach ($foundAll as $unePage) {
                    $page = new Page();
                    PageManager::addData(
                        $page,
                        $pageManager,
                        $unePage->getId(),
                        $unePage->getTitre(),
                        $unePage->getAuteur(),
                        $unePage->getContent(),
                        $unePage->getDate(),
                        $unePage->getPublie(),
                        $unePage->getUri(),
                        $unePage->getMenu(),
                        $unePage->getHome(),
                        $_POST['template'],
                        $unePage->getToken()
                    );
                }
                $location = Helpers::getUrl('Page', 'page');
                header("Location: $location");
            } else {
                throw new RouteException('Vous ne pouvez pas modifier le template comme ceci');
            }
        }
    }
}
