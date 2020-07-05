<?php 

namespace carsery\controllers;

use carsery\core\View;
use carsery\core\Session;
use carsery\core\Validator;
use carsery\core\Helpers;
use carsery\managers\ArticleManager;
use carsery\Managers\MessageManager;
use carsery\models\Article;
use carsery\managers\CategoryManager;
use carsery\managers\UserManager;
use carsery\core\Exceptions\RouteException;

class ForumController {

    public function forumAction() 
    {
        if(Session::estConnecte()){
            $myView = new View("forum");
            $articleManager = new ArticleManager();
            $categoryManager = new CategoryManager();
            // Initialisation du formulaire d'ajout d'article
            $configAddArticle = $articleManager->getArticleForm();
            $configAddArticle['fields']['categorie']['values'] = $categoryManager->findAll();
            // Récupération des articles
            $allArticles = $articleManager->findAll();
            $userManager = new UserManager();
            $currentUser = $userManager->find(intval($_SESSION["id"]));

            // Ajout des categories dans l'article
            foreach ($allArticles as $article){
                $article->setCategory($categoryManager->find($article->getCategory()->getId()));
                $articles[] = $article;
            }

            // passage des variables dans la vue
            $myView->assign('configAddArticle', $configAddArticle);
            $myView->assign('articles', $articles);
            $myView->assign('user', $currentUser);
        } else {
            include_once "./error/notConnected.php";
        }
    }

    public function readarticleAction()
    {
        if(Session::estConnecte()){
            $myView = new View("readarticle");
            $articleManager = new ArticleManager();
            $categoryManager = new CategoryManager();
            $messageManager = new MessageManager();
            $userManager = new UserManager();
            $currentUser = $userManager->find(intval($_SESSION["id"]));
            $article = $articleManager->find($_GET['id']);
            // Verification de l'article passer en paramètre
            if(isset($article)){
                $allMessage = $messageManager->findBy(array("article" => intval($article->getId())));
                $article->setCategory($categoryManager->find($article->getCategory()->getId()));
                $article->setAuthor($userManager->find($article->getAuthor()->getId()));

                // Ajout des utilisateur des messages
                foreach ($allMessage as $message){
                    $message->setAuthor($userManager->find($message->getAuthor()->getId()));
                    $messages[] = $message;
                }
                // Ajout des messages dans l'article
                $article->setMessages($messages);
                $myView->assign('article', $article);
                $myView->assign('user', $currentUser);
            } else {

            }
        }else {
            include_once "./error/notConnected.php";
        }
    }

    public function addarticleAction(){
        if(Session::estConnecte()){
            $myView = new View("forum");
            $articleManager = new ArticleManager();
            $categoryManager = new CategoryManager();
            // Initialisation du formulaire d'ajout d'article
            $configAddArticle = $articleManager->getArticleForm();
            $configAddArticle['fields']['categorie']['values'] = $categoryManager->findAll();

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

    public function updatearticleviewAction(){
        if(Session::estConnecte()){
            $myView = new View("editarticle");
            $articleManager = new ArticleManager();
            $article = $articleManager->find($_GET['id']);
            $categoryManager = new CategoryManager();
            // Initialisation du formulaire d'ajout d'article
            $configAddArticle = $articleManager->getArticleForm($article);
            $configAddArticle['fields']['categorie']['values'] = $categoryManager->findAll();
            // Configuration des valeurs de l'article a modifié
            $_POST['titre'] = $article->getTitle();
            $_POST['description'] = $article->getDescription();
            $myView->assign('configAddArticle', $configAddArticle);
        }else {
            include_once "./error/notConnected.php";
        }
    }

    public function updatearticleAction(){
        if(Session::estConnecte()){
            $myView = new View("forum");
            $articleManager = new ArticleManager();
            $categoryManager = new CategoryManager();
            // Initialisation du formulaire d'ajout d'article
            $configAddArticle = $articleManager->getArticleForm();
            $configAddArticle['fields']['categorie']['values'] = $categoryManager->findAll();

            $id = $_POST['id'];
            $article = $articleManager->find($id);
            // Verification de l'article passer en paramètre
            if($article != null && $_SERVER["REQUEST_METHOD"] == "POST"){
                //
                unset($_POST['id']);
                //Vérification des champs
                $errors = Validator::checkArticleForm($configAddArticle ,$_POST);
                //Insertion ou erreurs

                if(!empty($errors)){
                    $myView->assign('errors',$errors);
                } else {
                    if(!empty($_POST)){
                        // Récupération de toute les valeurs de l'article
                        $article->setTitle($_POST['titre']);
                        $article->setDescription($_POST['description']);

                        $article->setCategory(intval($_POST['categorie']));
                        $article->setAuthor(intval($_SESSION["id"]));
                        $article->setModificationDate(date("Y-m-d H:i:s"));

                        $articleManager->save($article);
                        $location = Helpers::getUrl('Forum','forum');
                        header("Location: $location");
                    }
                }
            }

        }else {
            include_once "./error/notConnected.php";
        }
    }

    public function removearticleAction(){

        $articleManager = new ArticleManager();
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $article = $articleManager->find(intval($_POST['id']));
            if(!isset($article)){
                throw new RouteException("L'article que vous voulez supprimer n'existe pas ou plus");
            }else {
                $articleManager->delete('id', intval($_POST['id']));
            }
        }
        $location = Helpers::getUrl('Forum','forum');
        header("Location: $location");
    
    }

    public function resolvearticleAction(){

        $articleManager = new ArticleManager();
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $article = $articleManager->find(intval($_POST['id']));
            if(!isset($article)){
                throw new RouteException("L'article que vous voulez marqué comme résolu n'existe pas ou plus");
            }else {
                $article->setResolve(1);
                $article->setAuthor($article->getAuthor()->getId());
                $article->setCategory($article->getCategory()->getId());
                $articleManager->save($article);
            }
        }
        $location = Helpers::getUrl('Forum','forum');
        header("Location: $location");

    }

    public function addmessagearticleAction(){
        if(Session::estConnecte()){
            $myView = new View("forum");
        }else {
            include_once "./error/notConnected.php";
        }
    }

    public function updatemessagearticleviewAction(){
        if(Session::estConnecte()){
            $myView = new View("forum");
        }else {
            include_once "./error/notConnected.php";
        }
    }

    public function removemessagearticleAction(){
        if(Session::estConnecte()){
            $myView = new View("forum");
        }else {
            include_once "./error/notConnected.php";
        }
    }

    public function banuserAction(){
        if(Session::estConnecte()){
            $myView = new View("forum");
        }else {
            include_once "./error/notConnected.php";
        }
    }
}