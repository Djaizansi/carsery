<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Session;
use carsery\core\View;
use carsery\Managers\PageManager;
use carsery\Managers\PostManager;

class myProjectController {

    public function viewAction()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $pageManager = new PageManager();
        $findAll = $pageManager->findAll();
        foreach($findAll as $myPage){
            if($myPage->getHome() == 1 && $uri == '/'){
                $uri = $myPage->getUri();
            }
        }
        $found = $pageManager->findByUri($uri);
        $public = $found->getPublie();
        if(isset($found))
        {
            if($public == 0 && Session::estConnecte() && Session::estAdmin() || $public == 1){
                //TODO : Verifier shortcode avant render
                $myView = new View('showPage','template1');
                $myView->assign('found',$found);
            }elseif($found->getHome() === 1){
                $myView = new View('showPage','template1');
                $myView->assign('found',$found);
            }
            elseif($public == 0 && !Session::estConnecte()) {
                throw new RouteException("Il faut être connecter pour accéder et modifier la page");
            }
        }else{
            throw new RouteException("La page n'existe pas");
        }
    }

    public function testQueryBuilderAction()
    {
        $postManager = new PostManager();

        $resultTp = $postManager->getUserPost(1);

        echo '<pre>';
        var_dump($resultTp);
    }
}
