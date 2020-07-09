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
use carsery\Managers\UserManager;
use carsery\models\Article;
use carsery\models\Message;
use carsery\models\User;

class FrontController
{

    public function frontforumAction()
    {
        $_SESSION['id'] = 1;
        $myView = new View('testwidget', 'template1');
        // Pour implementer le widget il faut renseigner la variable suivante $forumWidget
        $forumWidget = [];

        $articleManager = new ArticleManager();
        $categoryManager = new CategoryManager();
        $userManager = new UserManager();

        $articles = $articleManager->findAll();
        $categories = $categoryManager->findAll();

        $cats = [];
        foreach ($categories as $category) {
            foreach ($articles as $article) {
                if ($article->getCategory()->getId() == $category->getId()) {
                    if (isset($cats[$category->getName()])) {
                        $cats[$category->getName()] = array_merge($cats[$category->getName()], array($article));
                    } else {
                        $cats[$category->getName()] = array($article);
                    }
                }
            }
        }

        $forumWidget['categories'] = $cats;
        $configAddArticle = $articleManager->getAddArticleFront();
        $configAddArticle['fields']['categorie']['values'] = $categoryManager->findAll();
        $forumWidget['configAddArticle'] = $configAddArticle;

        if (Session::estConnecte()) {
            $user = $userManager->find($_SESSION['id']);
        } else {
            $user = new User();
            $user->setId(1);
            $user->setFirstname("Pierre");
            $user->setLastname("Dupond");
            $user->setBan(0);
            $user->setEmail("test@gmail.com");
        }
        $forumWidget['user'] = $user;
        $myView->assign('forumWidget', $forumWidget);
    }

    public function addarticleAction()
    {
        $_SESSION['id'] = 1;
        $myView = new View("testwidget", 'template1');
        $articleManager = new ArticleManager();
        $categoryManager = new CategoryManager();
        // Initialisation du formulaire d'ajout d'article
        $configAddArticle = $articleManager->getAddArticleFront();
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
                    $article->setTitle($_POST['titre']);
                    $article->setDescription($_POST['description']);

                    $article->setCategory(intval($_POST['categorie']));
                    $article->setAuthor(intval($_SESSION['id']));
                    $article->setResolve(0);
                    $articleManager->save($article);
                    $actionMessage = "L'article a été enregistré avec succès";
                    $location = Helpers::getUrl('Front', 'frontforum'). "?success=1&m=$actionMessage";
                    header("Location: $location");
                }
            }
        }
    }

    public function readarticleAction()
    {
        $_SESSION['id'] = 1;
        $myView = new View("readarticlefront", 'template1');
        $articleManager = new ArticleManager();
        $categoryManager = new CategoryManager();
        $messageManager = new MessageManager();
        $userManager = new UserManager();
        $currentUser = $userManager->find(intval($_SESSION["id"]));
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
        }
    }

    public function updatearticleviewAction()
    {
        $_SESSION['id'] = 1;
        $myView = new View("editarticlefront", 'template1');
        $articleManager = new ArticleManager();
        $article = $articleManager->find($_GET['id']);
        $categoryManager = new CategoryManager();
        // Initialisation du formulaire d'ajout d'article
        $configAddArticle = $articleManager->getAddArticleFront($article);
        $configAddArticle['fields']['categorie']['values'] = $categoryManager->findAll();
        // Configuration des valeurs de l'article a modifié
        $_POST['titre'] = $article->getTitle();
        $_POST['description'] = $article->getDescription();
        $myView->assign('configAddArticle', $configAddArticle);

    }

    public function updatearticleAction()
    {
        $_SESSION['id'] = 1;
        $myView = new View("testwidget", 'template1');
        $articleManager = new ArticleManager();
        $categoryManager = new CategoryManager();
        // Initialisation du formulaire d'ajout d'article
        $configAddArticle = $articleManager->getAddArticleFront();
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
                    $article->setTitle($_POST['titre']);
                    $article->setDescription($_POST['description']);

                    $article->setCategory(intval($_POST['categorie']));
                    $article->setAuthor(intval($_SESSION["id"]));
                    $article->setModificationDate(date("Y-m-d H:i:s"));

                    $articleManager->save($article);
                    $actionMessage = "L'article a été mis à jour avec succès";
                    $location = Helpers::getUrl('Front', 'frontforum'). "?success=1&m=$actionMessage";
                    header("Location: $location");
                }
            }
        }
    }

    public function removearticleAction()
    {

        $_SESSION['id'] = 1;
        $articleManager = new ArticleManager();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $article = $articleManager->find(intval($_POST['id']));
            if (!isset($article)) {
                throw new RouteException("L'article que vous voulez supprimer n'existe pas ou plus");
            } else {
                $articleManager->delete('id', intval($_POST['id']));
                $actionMessage = "L'article a été supprimé avec succès";
                $location = Helpers::getUrl('Front', 'frontforum'). "?success=1&m=$actionMessage";
                header("Location: $location");
            }
        }
    }

    public function resolvearticleAction()
    {
        $_SESSION['id'] = 1;
        $articleManager = new ArticleManager();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $article = $articleManager->find(intval($_POST['id']));
            if (!isset($article)) {
                throw new RouteException("L'article que vous voulez marqué comme résolu n'existe pas ou plus");
            } else {
                $article->setResolve(1);
                $article->setAuthor($article->getAuthor()->getId());
                $article->setCategory($article->getCategory()->getId());
                $articleManager->save($article);
                $actionMessage = "L'article a été marqué comme résolu avec succès";
                $location = Helpers::getUrl('Front', 'frontforum'). "?success=1&m=$actionMessage";
                header("Location: $location");
            }
        }
    }

    public function addmessageAction()
    {
        $_SESSION['id'] = 1;
        $myView = new View('readarticlefront', 'template1');
        $articleManager = new ArticleManager();
        $messageManager = new MessageManager();
        // Initialisation du formulaire d'ajout d'article
        $configAddMessage = $messageManager->getFrontMessageForm();
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
                    $message->setMessage($_POST['message']);
                    $message->setAuthor(intval($_SESSION['id']));
                    $message->setArticle(intval($article->getId()));
                    $messageManager->save($message);
                    $actionMessage = "Le message a été enregistré avec succès";
                    $location = Helpers::getUrl('Front', 'readarticle') . "?id=" . $article->getId() . "&success=1&m=$actionMessage";
                    header("Location: $location");
                }
            }
        }
    }

    public function updatemessageviewAction()
    {
        $_SESSION['id'] = 1;
        $myView = new View("editmessagefront", 'template1');
        $messageManager = new MessageManager();
        $message = $messageManager->find($_GET['id']);
        if (!isset($message)) {
            throw new RouteException("Le message que vous voulez modifier n'existe pas ou plus");
        } else {
            $configUpdateMessage = $messageManager->getFrontMessageForm($message);
            $_POST['message'] = $message->getMessage();
            $myView->assign('configUpdateMessage', $configUpdateMessage);
        }
    }

    public function updatemessageAction()
    {
        $_SESSION['id'] = 1;
        $myView = new View('editmessagefront', 'template1');
        $messageManager = new MessageManager();
        $id = $_POST['id'];
        $message = $messageManager->find($id);
        // Initialisation du formulaire d'ajout d'article
        $configUpdateMessage = $messageManager->getFrontMessageForm();
        // Verification du message passer en paramètre
        if ($message != null && $_SERVER["REQUEST_METHOD"] == "POST") {
            unset($_POST['id']);
            //Vérification des champs
            $errors = Validator::checkMessageForm($configUpdateMessage, $_POST);
            //Insertion ou erreurs
            if (!empty($errors)) {
                $myView->assign('errors', $errors);
            } else {
                $message->setMessage($_POST['message']);
                $message->setArticle(intval($message->getArticle()->getId()));
                $message->setAuthor(intval($message->getAuthor()->getId()));
                $message->setModificationDate(date("Y-m-d H:i:s"));
                $messageManager->save($message);
                $actionMessage = "Le message a été mis à jour avec succès";
                $location = Helpers::getUrl('Front', 'readarticle') . "?id=" . $message->getArticle(). "&success=1&m=$actionMessage";
                header("Location: $location");
            }
            $myView->assign('configUpdateMessage', $configUpdateMessage);
        }
    }

    public function removemessageAction()
    {
        $_SESSION['id'] = 1;
        $messageManager = new MessageManager();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $message = $messageManager->find(intval($_POST['id']));
            if (!isset($message)) {
                throw new RouteException("Le message que vous voulez supprimer n'existe pas ou plus");
            } else {
                $messageManager->delete('id', intval($_POST['id']));
                $actionMessage = "Le message a été supprimé avec succès";
                $location = Helpers::getUrl('Front', 'readarticle') . "?id=" . $message->getArticle()->getId() ."&success=1&m=$actionMessage";
                header("Location: $location");
            }
        }
    }


}