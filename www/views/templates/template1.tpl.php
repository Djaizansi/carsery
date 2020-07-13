<?php

use carsery\core\Helpers;
use carsery\core\Session;
use carsery\Managers\PageManager;

$pageManager = new PageManager();
$foundPage = $pageManager->findAll();
$foundMyPage = $pageManager->findByUri($_SERVER['REQUEST_URI']);
?>    

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>MyProject</title>
        <!-- Framework CSS -->
        <link rel="stylesheet" href="../public/dist/mains.css" />
        <link rel="stylesheet" href="../public/css/template1.css" />
        <link rel="stylesheet" href="../public/css/slider.css" />
        <script src="https://kit.fontawesome.com/42ce300797.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="../public/js/slider.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <header class="header">
                <?php //if($foundMyPage): ?>
                    <?php if(Session::estAdmin()): ?>
                        <a style="float: left;"href="<?=Helpers::getUrl('Page','page')?>">Retour Accueil</a>
                    <?php elseif(empty($_SESSION['id']) || Session::estClient()): ?>

                    <?php endif ?>
                <?php //endif ?>

            <?php foreach($foundPage as $unePage): ?>
                <?php if($unePage->getHome() == 1): ?>
                    <?php $myPage = 1 ?>
                    <a href="<?= Helpers::getUrl("myProject","view")?>" class="logo" style="text-decoration: none;">MyProject</a>
                    <?php break; ?>
                <?php elseif($unePage->getHome() == 0): ?>
                    <?php $myPage = 0 ?>
                <?php endif ?>
            <?php endforeach ?>
            
            <?php if($myPage == 0):?>
                <a href="#" class="logo">MyProject</a>
            <?php else: ?>     
            <?php endif ?>
            
            <div class="header-right">
                <?php foreach($foundPage as $unePage): ?>
                    <?php $classe = ($_SERVER['REQUEST_URI'] === $unePage->getUri()) ? 'active' : '' ?>
                    <?php if($unePage->getMenu() == 1): ?>
                        <a class="<?=$classe?>" href="<?= $unePage->getUri() ?>"> <?= ucfirst($unePage->getTitre()) ?> </a>
                    <?php endif ?>
                <?php endforeach ?>
                <?php if(!Session::estConnecte()): ?>
                    <a href="<?= Helpers::getUrl("User","login")?>">Connexion</a></li>
                    <a  href="<?= Helpers::getUrl("User","register")?>">Inscription</a></li>
                <?php elseif(Session::estClient()): ?>
                    <?php $classe = ($_SERVER['REQUEST_URI'] === $unePage->getUri()) ? 'active' : '' ?>
                    <a class="<?=$classe?>" href="#">Panier</a></li>
                    <a href="<?= Helpers::getUrl("User","deconnecter")?>">Deconnexion</i></a></li>
                <?php endif ?>
            </div>
            </header>
            <main>
                <div class="container">
                    <?php include "views/".$this->view.".view.php"; ?>
                    <!-- <div class="row">
                        <div class="col-6 txt-center">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate
                            quidem enim facilis similique necessitatibus eaque officia corporis,
                            maiores deserunt dolorem, voluptate a voluptatum. Voluptates quasi
                            placeat voluptatum adipisci animi corporis?
                        </div>
                        <div class="col-6 txt-center">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate
                            quidem enim facilis similique necessitatibus eaque officia corporis,
                            maiores deserunt dolorem, voluptate a voluptatum. Voluptates quasi
                            placeat voluptatum adipisci animi corporis?
                        </div>
                    </div> -->
                </div>
            </main>
        </div>

        <footer class="site-footer">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                    <h3>About</h3>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Deserunt perferendis, sit libero saepe eos omnis sed magnam
                        incidunt fuga, ex, recusandae distinctio voluptatibus dolor
                        cupiditate unde quos optio minus voluptatum.
                    </p>
                    </div>

                    <hr />

                    <div class="txt-center">
                    <!-- Add font awesome icons -->
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-twitter"></a>
                    <a href="#" class="fa fa-instagram"></a>
                    <a href="#" class="fa fa-snapchat-ghost"></a>
                    <a href="#" class="fa fa-pinterest"></a>
                    <a href="#" class="fa fa-google"></a>
                    <a href="#" class="fa fa-youtube"></a>
                    </div>
                </div>
            </div>
</footer>
    <script src="../public/js/script.js"></script>
    
    </body>
</html>