<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Helpers;
use carsery\core\Session;
use carsery\core\Validator;
use carsery\core\View;
use carsery\Managers\ArticleManager;
use carsery\Managers\CategoryManager;
use carsery\Managers\MessageManager;
use carsery\Managers\PageManager;
use carsery\Managers\ShortCodeManager;
use carsery\Managers\UserManager;
use carsery\models\Article;
use carsery\models\Category;
use carsery\models\Message;


$pageManager = new PageManager();
$shortManager = new ShortCodeManager();

$allPage = $pageManager->findAll();
$allShort = $shortManager->findAll();
$foundtest = false;

foreach($allPage as $unePage){
    $myContent = $unePage->getContent();
    foreach($allShort as $unShort){
        $shortcode = $unShort->getShortcode();
        $verifCode = View::checkShortcode($myContent);
        foreach($verifCode as $unCode){
            if($unCode == $shortcode && $unShort->getType() == "forum"){
                $foundtest = true;
                break;
            }
        }
    }
}

if(!isset($allPage) || empty($allPage)){
    $template = '';
}

foreach($allPage as $unePage){
    if($unePage->getTemplate() == 0){
        $template = 'template1';
    }elseif($unePage->getTemplate() == 1){
        $template = 'template2';
    }
}



define('FOUND',$foundtest);
define('TEMPLATE',$template);

class ForumController
{

    public function forumAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $myView = new View("forum");
            $articleManager = new ArticleManager();
            $categoryManager = new CategoryManager();
            $categories = $categoryManager->findAll();
            // Initialisation du formulaire d'ajout d'article
            $configAddArticle = $articleManager->getArticleForm();
            $configAddArticle['fields']['categorie']['values'] = $categoryManager->findAll();
            $configAddCategory = $categoryManager->getCategoryForm();
            // Récupération des articles
            $allArticles = $articleManager->findAll();
            $userManager = new UserManager();
            $currentUser = $userManager->find(intval($_SESSION["id"]));
            $articles = null;

            // Ajout des categories dans l'article
            foreach ($allArticles as $article) {
                $article->setCategory($categoryManager->find($article->getCategory()->getId()));
                $articles[] = $article;
            }

            // passage des variables dans la vue
            $myView->assign('configAddArticle', $configAddArticle);
            $myView->assign('configAddCategory', $configAddCategory);
            $myView->assign('articles', $articles);
            $myView->assign('user', $currentUser);
            $myView->assign('categories', $categories);
        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }

    public function readarticleAction()
    {
        if (Session::estConnecte()) {
            if(Session::estClient() && FOUND){
                $myView = new View("readarticle", TEMPLATE);
            }elseif(Session::estAdmin()){
                $myView = new View("readarticle");
            }
            if(Session::estAdmin() || Session::estClient() && FOUND){
                $articleManager = new ArticleManager();
                $categoryManager = new CategoryManager();
                $messageManager = new MessageManager();
                $userManager = new UserManager();
                $currentUser = $userManager->find(intval($_SESSION["id"]));
                if(!isset($_GET['id']) || empty($_GET['id'])){
                    $location = Helpers::getUrl('Forum','forum');
                    header("Location: $location");
                }else{
                    $article = $articleManager->find($_GET['id']);
                    // Verification de l'article passer en paramètre
                    if (isset($article)) {
                        $allMessage = $messageManager->findBy(array("article" => intval($article->getId())));
                        $article->setCategory($categoryManager->find($article->getCategory()->getId()));
                        $article->setAuthor($userManager->find($article->getAuthor()->getId()));
                        $messages = null;

                        // Ajout des utilisateur des messages
                        foreach ($allMessage as $message) {
                            $message->setAuthor($userManager->find($message->getAuthor()->getId()));
                            $messages[] = $message;
                        }
                        // Ajout des messages dans l'article
                        $article->setMessages($messages);
                        $myView->assign('article', $article);
                        $myView->assign('user', $currentUser);
                    } else {
                        throw new RouteException("L'article n'existe pas");
                    }
                }
            }else{
                throw new RouteException("Les liens ne sont pas correctes");
            }
        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }

    public function addarticleAction()
    {
        if (Session::estConnecte()) {
            if(Session::estClient() && FOUND){
                $myView = new View("forum",TEMPLATE);
            }elseif(Session::estAdmin()){
                $myView = new View("forum");
            }
            if(Session::estAdmin() || Session::estClient() && FOUND){
                $articleManager = new ArticleManager();
                $categoryManager = new CategoryManager();
                // Initialisation du formulaire d'ajout d'article
                $configAddArticle = $articleManager->getArticleForm();
                $configAddArticle['fields']['categorie']['values'] = $categoryManager->findAll();

                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    //Vérification des champs
                    $errors = Validator::checkArticleForm($configAddArticle, $_POST);
                    //Insertion ou erreurs

                    if (!empty($errors)) {
                        $myView->assign('errors', $errors);
                    } else {
                        if (!empty($_POST)) {
                            $article = new Article();
                            $article->setTitle(htmlspecialchars($_POST['titre']));
                            $article->setDescription(htmlspecialchars($_POST['description']));

                            $article->setCategory(intval($_POST['categorie']));
                            $article->setAuthor(intval($_SESSION["id"]));
                            $article->setResolve(0);

                            $articleManager->save($article);

                            $actionMessage = "L'article a été enregistré avec succès";
                            if(Session::estClient()){
                                $location = $_SESSION['uriForum']. "?success=1&m=$actionMessage";
                            }elseif(Session::estAdmin()){
                                $location = Helpers::getUrl('Forum', 'forum'). "?success=1&m=$actionMessage";
                            }else{
                                throw new RouteException("Une erreur est survenue");
                            }
                            header("Location: $location");
                        } else {
                            throw new RouteException("Une erreur est survenue");
                        }
                    }
                }else{
                    throw new RouteException("Une erreur est survenue");
                }
            }else{
                throw new RouteException("Les liens ne sont pas correctes");
            }
        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }

    public function updatearticleviewAction()
    {
        if (Session::estConnecte()) {
            $articleManager = new ArticleManager();
            $article = $articleManager->find($_GET['id']);
            if(isset($article)){
                if(Session::estClient() && $article->getAuthor()->getId() == $_SESSION['id']){
                    $myView = new View("editarticle",TEMPLATE);
                }elseif(Session::estAdmin()){
                    $myView = new View("editarticle");
                }elseif(Session::estClient() && $article->getAuthor()->getId() != $_SESSION['id']){
                    throw new RouteException("Vous ne pouvez pas modifier cet article");
                }
                $categoryManager = new CategoryManager();
                // Initialisation du formulaire d'ajout d'article
                $configAddArticle = $articleManager->getArticleForm($article);
                $configAddArticle['fields']['categorie']['values'] = $categoryManager->findAll();
                // Configuration des valeurs de l'article a modifié
                $_POST['titre'] = $article->getTitle();
                $_POST['description'] = $article->getDescription();
                $myView->assign('configAddArticle', $configAddArticle);
            }elseif(!isset($article)){
                throw new RouteException("Cette article n'existe pas");
            }
        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }

    public function updatearticleAction()
    {
        if (Session::estConnecte()) {
            if(Session::estClient() && FOUND){
                $myView = new View("forum",TEMPLATE);
            }elseif(Session::estAdmin()){
                $myView = new View("forum");
            }
            if(Session::estAdmin() || Session::estClient() && FOUND){
                $articleManager = new ArticleManager();
                $categoryManager = new CategoryManager();

                // Initialisation du formulaire d'ajout d'article
                $configAddArticle = $articleManager->getArticleForm();
                $configAddArticle['fields']['categorie']['values'] = $categoryManager->findAll();

                $id = $_POST['id'];
                $article = $articleManager->find($id);
                // Verification de l'article passer en paramètre
                if ($article != null && $_SERVER["REQUEST_METHOD"] == "POST") {
                    //
                    unset($_POST['id']);
                    //Vérification des champs
                    $errors = Validator::checkArticleForm($configAddArticle, $_POST);
                    //Insertion ou erreurs

                    if (!empty($errors)) {
                        $myView->assign('errors', $errors);
                    } else {
                        if (!empty($_POST)) {
                            // Récupération de toute les valeurs de l'article
                                $article->setTitle(htmlspecialchars($_POST['titre']));
                                $article->setDescription(htmlspecialchars($_POST['description']));

                                $article->setCategory(intval($_POST['categorie']));
                                $article->setAuthor(intval($article->getAuthor()->getId()));
                                $article->setModificationDate(date("Y-m-d H:i:s"));

                                $articleManager->save($article);
                                $actionMessage = "L'article a été mis à jour avec succès";
                                if(Session::estAdmin()){
                                    $location = Helpers::getUrl('Forum', 'forum'). "?success=1&m=$actionMessage";
                                }elseif(Session::estClient()){
                                    $location = $_SESSION['uriForum']. "?success=1&m=$actionMessage";
                                    /* $_SESSION['reussite'] = "updatearticle"; */
                                }
                                header("Location: $location");
                        }
                    }
                }
            }else{
                throw new RouteException("Les liens ne sont pas correctes");
            }

        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }

    public function removearticleAction()
    {

        if (Session::estConnecte() && Session::estAdmin()) {
            $articleManager = new ArticleManager();
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $article = $articleManager->find(intval($_POST['id']));
                if (!isset($article)) {
                    throw new RouteException("L'article que vous voulez supprimer n'existe pas ou plus");
                } else {
                    $articleManager->delete('id', intval($_POST['id']));
                    $actionMessage = "L'article a été supprimé avec succès";
                    $location = Helpers::getUrl('Forum', 'forum'). "?success=1&m=$actionMessage";
                    header("Location: $location");
                }
            }
        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }

    }

    public function resolvearticleAction()
    {
        if (Session::estConnecte()) {
            $articleManager = new ArticleManager();
                $article = $articleManager->find(intval($_GET['id']));
                if (!isset($article)) {
                    throw new RouteException("L'article que vous voulez marqué comme résolu n'existe pas ou plus");
                } else {
                    $article->setResolve(1);
                    $article->setAuthor($article->getAuthor()->getId());
                    $article->setCategory($article->getCategory()->getId());
                    $articleManager->save($article);
                    $actionMessage = "L'article a été marqué comme résolu avec succès";

                    if(Session::estAdmin()){
                        $location = Helpers::getUrl('Forum', 'forum'). "?success=1&m=$actionMessage";
                    }elseif(Session::estClient()){
                        $location = $_SESSION['uriForum']. "?success=1&m=$actionMessage";
                        /* $_SESSION['reussite'] = "resolvearticle"; */
                    }
                    header("Location: $location");
                }
        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }

    }

    public function addmessagearticleAction()
    {
        if (Session::estConnecte()) {
            if(Session::estClient() && FOUND){
                $myView = new View("readarticle",TEMPLATE);
            }elseif(Session::estAdmin()){
                $myView = new View("readarticle");
            }
            if(Session::estAdmin() || Session::estClient() && FOUND){
                $articleManager = new ArticleManager();
                $messageManager = new MessageManager();
                // Initialisation du formulaire d'ajout d'article
                $configAddMessage = $messageManager->getMessageForm();
                $article = $articleManager->find($_POST["article"]);
                if ($article != null && $_SERVER["REQUEST_METHOD"] == "POST") {
                    unset($_POST['article']);
                    //Vérification des champs
                    $errors = Validator::checkMessageForm($configAddMessage, $_POST);
                    //Insertion ou erreurs
                    if (!empty($errors)) {
                        $myView->assign('errors', $errors);
                    } else {
                        if (!empty($_POST)) {
                            $message = new Message();
                            $message->setMessage(htmlspecialchars($_POST['message']));
                            $message->setAuthor(intval($_SESSION['id']));
                            $message->setArticle(intval($article->getId()));
                            $messageManager->save($message);
                            $actionMessage = "Le message a été enregistré avec succès";
                            $location = Helpers::getUrl('Forum', 'readarticle') . "?id=" . $article->getId() . "&success=1&m=$actionMessage";
                            header("Location: $location");
                        }
                    }
                }
            }else{
                throw new RouteException("Les liens ne sont pas correctes");
            }
        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }

    public function updatemessagearticleviewAction()
    {
        if (Session::estConnecte()) {
            $messageManager = new MessageManager();
            $message = $messageManager->find($_GET['id']);

            if(Session::estClient() && $message->getAuthor()->getId() == $_SESSION['id']){
                $myView = new View("editmessage",TEMPLATE);
            }elseif(Session::estAdmin()){
                $myView = new View("editmessage");
            }else{
                throw new RouteException("Vous ne pouvez pas modifier ce message");
            }

            if (!isset($message)) {
                throw new RouteException("Le message que vous voulez modifier n'existe pas ou plus");
            } else {
                $configUpdateMessage = $messageManager->getMessageForm($message);
                $_POST['message'] = $message->getMessage();
                $myView->assign('configUpdateMessage', $configUpdateMessage);
            }
        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }

    public function updatemessagearticleAction()
    {
        if (Session::estConnecte()) {
            if(Session::estClient() && FOUND){
                $myView = new View("editmessage",TEMPLATE);
            }elseif(Session::estAdmin()){
                $myView = new View("editmessage");
            }
            if(Session::estAdmin() || Session::estClient() && FOUND){
                $messageManager = new MessageManager();
                $id = $_POST['id'];
                $message = $messageManager->find($id);
                // Initialisation du formulaire d'ajout d'article
                $configUpdateMessage = $messageManager->getMessageForm();
                // Verification du message passer en paramètre
                if ($message != null && $_SERVER["REQUEST_METHOD"] == "POST") {
                    unset($_POST['id']);
                    //Vérification des champs
                    $errors = Validator::checkMessageForm($configUpdateMessage, $_POST);
                    //Insertion ou erreurs
                    if (!empty($errors)) {
                        $myView->assign('errors', $errors);
                    } else {
                        $message->setMessage(htmlspecialchars($_POST['message']));
                        $message->setArticle(intval($message->getArticle()->getId()));
                        $message->setAuthor(intval($message->getAuthor()->getId()));
                        $message->setModificationDate(date("Y-m-d H:i:s"));
                        $messageManager->save($message);
                        $actionMessage = "Le message a été mis à jour avec succès";
                        $location = Helpers::getUrl('Forum', 'readarticle') . "?id=" . $message->getArticle(). "&success=1&m=$actionMessage";
                        header("Location: $location");
                    }
                    $myView->assign('configUpdateMessage', $configUpdateMessage);
                }
            }else{
                throw new RouteException("Les liens ne sont pas correctes");
            }
        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }

    public function removemessagearticleAction()
    {
        if (Session::estConnecte()) {
            if(Session::estClient() && FOUND || Session::estAdmin()){
                $messageManager = new MessageManager();
                    $message = $messageManager->find(intval($_GET['id']));
                    if (!isset($message)) {
                        throw new RouteException("Le message que vous voulez supprimer n'existe pas ou plus");
                    } else {
                        $messageManager->delete('id', intval($_GET['id']));
                        $actionMessage = "Le message a été supprimé avec succès";
                        if(Session::estClient()){
                            $location = $_SESSION['uriForum'];
                            $_SESSION['reussite'] = "deletemessage";
                        }elseif(Session::estAdmin()){
                            $location = Helpers::getUrl('Forum', 'forum');
                            $_SESSION['reussite'] = "deletemessage";
                        }
                        header("Location: $location");
                    }
            }else{
                throw new RouteException("Les liens ne sont pas correctes");
            }
        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }

    public function banuserAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $userManager = new UserManager();
            $messageManager = new MessageManager();
            $currentUser = $userManager->find($_SESSION['id']);
            $message = $messageManager->find($_POST['id']);
            if ($message != null && $currentUser->getStatus() == "Admin") {
                $userToBan = $userManager->find($message->getAuthor()->getId());
                if($userToBan != null){
                    $userToBan->setBan(1);
                    $userManager->save($userToBan);
                    $actionMessage = "L'utilisateur a été banni avec succès";
                    $location = Helpers::getUrl('Forum', 'readarticle') . "?id=" . $message->getArticle()->getId(). "&success=1&m=$actionMessage";
                    header("Location: $location");
                }
            }
        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }


    public function addcategoryAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $myView = new View("forum");
            $categoryManager = new CategoryManager();
            // Initialisation du formulaire d'ajout d'article
            $configAddCategory = $categoryManager->getCategoryForm();
            if(!empty($_POST)){
                $errors = Validator::checkCategoryForm($configAddCategory, $_POST);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(!empty($_POST)){
                    if (!empty($errors)) {
                        $myView->assign('errors', $errors);
                    } else {
                        if (!empty($_POST)) {
                            $category = new Category();
                            $category->setName(htmlspecialchars($_POST['name']));
                            $categoryManager->save($category);
                            $actionMessage = "La catégorie a été enregistré avec succès";
                            $location = Helpers::getUrl('Forum', 'forum'). "?success=1&m=$actionMessage";
                            header("Location: $location");
                        }
                    }
                }
            }

        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }

    public function updatecategoryviewAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $myView = new View("editcategory");
            $categoryManager = new CategoryManager();
            $category = $categoryManager->find($_GET['id']);
            // Initialisation du formulaire d'ajout d'article
            $configUpdateCategory = $categoryManager->getCategoryForm($category);
            // Configuration des valeurs de l'article a modifié
            $_POST['name'] = $category->getName();
            $myView->assign('configUpdateCategory', $configUpdateCategory);
        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }

    public function updatecategoryAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $myView = new View('editcategory');
            $categoryManager = new CategoryManager();
            $id = $_POST['id'];
            $category = $categoryManager->find($id);
            // Initialisation du formulaire d'ajout d'article
            $configUpdateCategory = $categoryManager->getCategoryForm();
            // Verification du message passer en paramètre
            if ($category != null && $_SERVER["REQUEST_METHOD"] == "POST") {
                unset($_POST['id']);
                //Vérification des champs
                $errors = Validator::checkCategoryForm($configUpdateCategory, $_POST);
                //Insertion ou erreurs
                if (!empty($errors)) {
                    $myView->assign('errors', $errors);
                } else {
                    $category->setName(htmlspecialchars($_POST['name']));
                    $categoryManager->save($category);
                    $actionMessage = "La catégorie a été mis à jour avec succès";
                    $location = Helpers::getUrl('Forum', 'forum'). "?success=1&m=$actionMessage";
                    header("Location: $location");
                }
                $myView->assign('configUpdateMessage', $configUpdateCategory);
            }
        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }

    public function removecategoryAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $categoryManager = new CategoryManager();
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $category = $categoryManager->find(intval($_POST['id']));
                if (!isset($category)) {
                    throw new RouteException("La catégorie que vous voulez supprimer n'existe pas ou plus");
                } else {
                    $categoryManager->delete('id', intval($_POST['id']));
                    $actionMessage = "La catégorie a été supprimé avec succès";
                    $location = Helpers::getUrl('Forum', 'forum') . "?success=1&m=$actionMessage";
                    header("Location: $location");
                }
            }
        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }

    public function unbanuserAction()
    {
        if (Session::estConnecte() && Session::estAdmin()) {
            $userManager = new UserManager();
            $messageManager = new MessageManager();
            $message = $messageManager->find($_POST['id']);
            if ($message != null && Session::estAdmin()) {
                $userToBan = $userManager->find($message->getAuthor()->getId());
                if($userToBan != null){
                    $userToBan->setBan(0);
                    $userManager->save($userToBan);
                    $actionMessage = "L'utilisateur a été dé-banni avec succès";
                    $location = Helpers::getUrl('Forum', 'readarticle') . "?id=" . $message->getArticle()->getId(). "&success=1&m=$actionMessage";
                    header("Location: $location");
                }
            }
        } else {
            throw new RouteException("Vous n'êtes pas connecté");
        }
    }
}