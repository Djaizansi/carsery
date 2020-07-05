<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Helpers;
use carsery\core\Session;
use carsery\core\Validator;
use carsery\core\View;
use carsery\managers\ArticleManager;
use carsery\managers\CategoryManager;
use carsery\Managers\MessageManager;
use carsery\managers\UserManager;
use carsery\models\Article;
use carsery\models\Category;
use carsery\models\Message;

class ForumController
{

    public function forumAction()
    {
        if (Session::estConnecte()) {
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
            include_once "./error/notConnected.php";
        }
    }

    public function readarticleAction()
    {
        if (Session::estConnecte()) {
            $myView = new View("readarticle");
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
            } else {

            }
        } else {
            include_once "./error/notConnected.php";
        }
    }

    public function addarticleAction()
    {
        if (Session::estConnecte()) {
            $myView = new View("forum");
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
                        $article->setTitle($_POST['titre']);
                        $article->setDescription($_POST['description']);

                        $article->setCategory(intval($_POST['categorie']));
                        $article->setAuthor(intval($_SESSION["id"]));
                        $article->setResolve(0);

                        $articleManager->save($article);
                        $location = Helpers::getUrl('Forum', 'forum');
                        header("Location: $location");
                    } else {
                    }

                }
            }

        } else {
            include_once "./error/notConnected.php";
        }
    }

    public function updatearticleviewAction()
    {
        if (Session::estConnecte()) {
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
        } else {
            include_once "./error/notConnected.php";
        }
    }

    public function updatearticleAction()
    {
        if (Session::estConnecte()) {
            $myView = new View("forum");
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
                        $article->setTitle($_POST['titre']);
                        $article->setDescription($_POST['description']);

                        $article->setCategory(intval($_POST['categorie']));
                        $article->setAuthor(intval($_SESSION["id"]));
                        $article->setModificationDate(date("Y-m-d H:i:s"));

                        $articleManager->save($article);
                        $location = Helpers::getUrl('Forum', 'forum');
                        header("Location: $location");
                    }
                }
            }

        } else {
            include_once "./error/notConnected.php";
        }
    }

    public function removearticleAction()
    {

        if (Session::estConnecte()) {
            $articleManager = new ArticleManager();
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $article = $articleManager->find(intval($_POST['id']));
                if (!isset($article)) {
                    throw new RouteException("L'article que vous voulez supprimer n'existe pas ou plus");
                } else {
                    $articleManager->delete('id', intval($_POST['id']));
                }
            }
            $location = Helpers::getUrl('Forum', 'forum');
            header("Location: $location");
        } else {
            include_once "./error/notConnected.php";
        }

    }

    public function resolvearticleAction()
    {
        if (Session::estConnecte()) {
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
                }
            }
            $location = Helpers::getUrl('Forum', 'forum');
            header("Location: $location");
        } else {
            include_once "./error/notConnected.php";
        }

    }

    public function addmessagearticleAction()
    {
        if (Session::estConnecte()) {
            $myView = new View('readarticle');
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
                        $message->setMessage($_POST['message']);
                        $message->setAuthor(intval($_SESSION['id']));
                        $message->setArticle(intval($article->getId()));
                        $messageManager->save($message);
                    }
                    $location = Helpers::getUrl('Forum', 'readarticle') . "?id=" . $article->getId();
                    header("Location: $location");
                }
            }
        } else {
            include_once "./error/notConnected.php";
        }
    }

    public function updatemessagearticleviewAction()
    {
        if (Session::estConnecte()) {
            $myView = new View("editmessage");
            $messageManager = new MessageManager();
            $message = $messageManager->find($_GET['id']);
            if (!isset($message)) {
                throw new RouteException("Le message que vous voulez modifier n'existe pas ou plus");
            } else {
                $configUpdateMessage = $messageManager->getMessageForm($message);
                $_POST['message'] = $message->getMessage();
                $myView->assign('configUpdateMessage', $configUpdateMessage);
            }
        } else {
            include_once "./error/notConnected.php";
        }
    }

    public function updatemessagearticleAction()
    {
        if (Session::estConnecte()) {
            $myView = new View('editmessage');
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
                    $message->setMessage($_POST['message']);
                    $message->setArticle(intval($message->getArticle()->getId()));
                    $message->setAuthor(intval($message->getAuthor()->getId()));
                    $message->setModificationDate(date("Y-m-d H:i:s"));
                    $messageManager->save($message);
                    $location = Helpers::getUrl('Forum', 'readarticle') . "?id=" . $message->getArticle();
                    header("Location: $location");
                }
                $myView->assign('configUpdateMessage', $configUpdateMessage);
            }
        } else {
            include_once "./error/notConnected.php";
        }
    }

    public function removemessagearticleAction()
    {
        if (Session::estConnecte()) {
            $messageManager = new MessageManager();
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $message = $messageManager->find(intval($_POST['id']));
                if (!isset($message)) {
                    throw new RouteException("Le message que vous voulez supprimer n'existe pas ou plus");
                } else {
                    $messageManager->delete('id', intval($_POST['id']));
                }
            }
            $location = Helpers::getUrl('Forum', 'readarticle') . "?id=" . $message->getArticle()->getId();
            header("Location: $location");
        } else {
            include_once "./error/notConnected.php";
        }
    }

    public function banuserAction()
    {
        if (Session::estConnecte()) {
            $userManager = new UserManager();
            $messageManager = new MessageManager();
            $currentUser = $userManager->find($_SESSION['id']);
            $message = $messageManager->find($_POST['id']);
            if ($message != null && $currentUser->getStatus() == "Admin") {
                $userToBan = $userManager->find($message->getAuthor()->getId());
                if($userToBan != null){
                    $userToBan->setBan(1);
                    $userManager->save($userToBan);
                    $location = Helpers::getUrl('Forum', 'readarticle') . "?id=" . $message->getArticle()->getId();
                    header("Location: $location");
                }
            }
        } else {
            include_once "./error/notConnected.php";
        }
    }


    public function addcategoryAction()
    {
        if (Session::estConnecte()) {
            $myView = new View("forum");
            $categoryManager = new CategoryManager();
            // Initialisation du formulaire d'ajout d'article
            $configAddCategory = $categoryManager->getCategoryForm();

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                //Vérification des champs
                $errors = Validator::checkArticleForm($configAddCategory, $_POST);
                //Insertion ou erreurs
                if (!empty($errors)) {
                    $myView->assign('errors', $errors);
                } else {
                    if (!empty($_POST)) {
                        $category = new Category();
                        $category->setName($_POST['name']);
                        $categoryManager->save($category);
                        $location = Helpers::getUrl('Forum', 'forum');
                        header("Location: $location");
                    }
                }
            }

        } else {
            include_once "./error/notConnected.php";
        }
    }

    public function updatecategoryviewAction()
    {
        if (Session::estConnecte()) {
            $myView = new View("editcategory");
            $categoryManager = new CategoryManager();
            $category = $categoryManager->find($_GET['id']);
            // Initialisation du formulaire d'ajout d'article
            $configUpdateCategory = $categoryManager->getCategoryForm($category);
            // Configuration des valeurs de l'article a modifié
            $_POST['name'] = $category->getName();
            $myView->assign('configUpdateCategory', $configUpdateCategory);
        } else {
            include_once "./error/notConnected.php";
        }
    }

    public function updatecategoryAction()
    {
        if (Session::estConnecte()) {
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
                    $category->setName($_POST['name']);
                    $categoryManager->save($category);
                    $location = Helpers::getUrl('Forum', 'forum');
                    header("Location: $location");
                }
                $myView->assign('configUpdateMessage', $configUpdateCategory);
            }
        } else {
            include_once "./error/notConnected.php";
        }
    }

    public function removecategoryAction()
    {
        if (Session::estConnecte()) {
            $categoryManager = new CategoryManager();
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $category = $categoryManager->find(intval($_POST['id']));
                if (!isset($category)) {
                    throw new RouteException("Le message que vous voulez supprimer n'existe pas ou plus");
                } else {
                    $categoryManager->delete('id', intval($_POST['id']));
                }
            }
            $location = Helpers::getUrl('Forum', 'forum');
            header("Location: $location");
        } else {
            include_once "./error/notConnected.php";
        }
    }
}