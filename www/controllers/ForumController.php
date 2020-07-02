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
        $categoryManager = new CategoryManager();
        $articles = $articleManager->findAll();
        $myView = new View("forum");
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $article = $articleManager->find(inval($_POST['delete']));
            if(!isset($article)){
                throw new RouteException("L'article que vous voulez supprimer n'existe pas ou plus");
            }else {
                $articleManager->delete('id', inval($_POST['delete']));
                $articles = $articleManager->findAll();
                $configAddArticle = $articleManager->getArticleForm();
                $configAddArticle['fields']['categorie']['value'] = $categoryManager->findAll();
                $myView->assign('configAddArticle', $configAddArticle);
                $myView->assign('removeMessage', "l'article " . $article->getTitle() ." a été supprimé avec succès");
            }
        }
        $myView->assign('articles', $articles);
    
    }

    public function addarticleAction(){
        if(Session::estConnecte()){
            $myView = new View("forum");
            $articleManager = new ArticleManager();
            $categoryManager = new CategoryManager();
            $configAddArticle = $articleManager->getArticleForm();
            $configAddArticle['fields']['categorie']['value'] = $categoryManager->findAll();

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

                        $article->setCategory(intval($_POST['categorie']));
                        $article->setAuthor(intval($_SESSION["id"]));
                        $article->setResolve(0);

                        $articleManager->save($article);
                        $articles = $articleManager->findAll();
                        $myView->assign('articles', $articles);
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