<?php 

namespace carsery\controllers;

use carsery\core\View;
use carsery\core\Session;
use carsery\core\Validator;
use carsery\core\Helpers;
use carsery\managers\ArticleManager;
use carsery\models\Article;
use carsery\managers\CategoryManager;
use carsery\managers\UserManager;

class ForumController {

    public function forumAction() 
    {
        $myView = new View("forum");
        $articleManager = new ArticleManager();
        $categoryManager = new CategoryManager();
        $configAddArticle = $articleManager->getArticleForm();
        $configAddArticle['fields']['categorie']['value'] = $categoryManager->findAll();
        $articles = $articleManager->findAll();
        $myView->assign('configAddArticle', $configAddArticle);
        $myView->assign('articles', $articles);
    }

    public function readarticleAction()
    {
        if(Session::estConnecte()){
            $myView = new View("forum");
        }else {
            include_once "./error/notConnected.php";
        }
    }

    public function removearticleAction(){

        $articleManager = new ArticleManager();
        $article = $articleManager->find($_GET['id']);
        $myView = new View("forum");

        if(!isset($article)){
            throw new RouteException("L'article que vous voulez supprimer n'existe pas ou plus");
        }else {
            $articleManager->delete($_GET['id']);
            $myView->assign('removeMessage', "l'article " . $article->getTitle() ." a été supprimé avec succès");
        }
    
    }

    public function addarticleAction(){
        if(Session::estConnecte()){
            $myView = new View("forum");
            $articleManager = new ArticleManager();
            $userManager = new UserManager();
            $categoryManager = new CategoryManager();
            $configAddArticle = $articleManager->getArticleForm();
            $configAddArticle['fields']['categorie']['value'] = $categoryManager->findAll();
            $articles = $articleManager->findAll();

            if($_SERVER["REQUEST_METHOD"] == "POST"){

                //Vérification des champs
                $errors = Validator::checkArticleForm($configAddArticle ,$_POST);
                //Insertion ou erreurs

                if(!empty($errors)){
                    $myView->assign('errors',$errors);
                } else {
                    if(!empty($_POST)){
                        $article = new Article();
                        $article->setTitle($_POST['titre']);
                        $article->setDescription($_POST['description']);

                        $article->setCategory($_POST['categorie']);
                        $article->setAuthor($_SESSION["id"]);

                        $articleManager->save($article);
                        $myView->assign('articles', $articles);

                        $location = Helpers::getUrl('Forum','forum');
                        header("Location: $location");
                    }
                    else {}
                            
                    }
            }

        }else {
            include_once "./error/notConnected.php";
        }
    }

    public function addmessagearticleAction(){
        if(Session::estConnecte()){
            $myView = new View("forum");
        }else {
            include_once "./error/notConnected.php";
        }
    }

    public function resolvearticleAction(){

    }

}