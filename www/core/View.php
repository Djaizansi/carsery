<?php

namespace carsery\core;

use carsery\core\Exceptions\RouteException;
use carsery\core\Session;
use carsery\Managers\UserManager;


class View
{
    private $template; //pour accéder à template, $this->template
    private $view;
    private $data = [];

    public function __construct($view, $template="back")
    {
        $this->setTemplate($template);
        $this->setView($view);
        if($this->template === "back" && Session::estConnecte()){
            $userManager = new UserManager();
            $utilisateur = $userManager->find($_SESSION['id']);
            if(!is_null($utilisateur)){
                $prenom = htmlspecialchars($utilisateur->getFirstname());
                self::assign("firstname",$prenom);
            }else {
                session_destroy();
            }
        }
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate($t)
    {
        $this->template = strtolower(trim($t));
        if (!file_exists("views/templates/".$this->template.".tpl.php")) {
            die("Le template n'existe pas");
        }
    }

    public function addModal($modal, $data)
    {
        if (!file_exists("views/modals/".$modal.".mod.php")) {
            die("Le modal n'existe pas!!!");
        }
        include "views/modals/".$modal.".mod.php";
    }

    public function setView($v)
    {
        $titre = $this->view = strtolower(trim($v));
        $unTitre = explode('?',$titre)[0];
        if (!file_exists("views/".$unTitre.".view.php")) {
            die("La vue n'existe pas");
        }
    }

    public function assign($key, $value)
    {
        $this->data[$key] = $value; //permet d'envoyer une variable à la vue.
    }

    public function __destruct()
    {
        //$this->data = ["firstname"=>"yves"];
        extract($this->data);
        include "views/templates/".$this->template.".tpl.php";
        //$firstname = "yves";
    }

    /**
     * Get the value of template
     */ 
}
