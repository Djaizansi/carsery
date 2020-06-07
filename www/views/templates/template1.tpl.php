<?php

use carsery\Managers\PageManager;

$pageManager = new PageManager();
$foundPage = $pageManager->findAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../public/dist/mains.css">
    <link rel="stylesheet" href="../public/css/templates1.css">
    <link rel="stylesheet" href="../public/css/sliders.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../public/js/template1.js"></script>
    <script src="../public/js/slider.js"></script>
    <title>MyProject</title>
</head>
<body>
    <header>
        <div class="container clearfix">
            <a href="#" class="logo" style="text-decoration: none;">
                <p style="color: #000000;">MyProject</p>
            </a>
            <nav>
                <ul>
                    <?php foreach($foundPage as $unePage): ?>
                        <?php if($unePage->getMenu() == 1): ?>
                            <li><a href="<?= $unePage->getUri() ?>"> <?= ucfirst($unePage->getTitre()) ?> </a></li>
                        <?php endif ?>
                    <?php endforeach ?>

                    <li><a href="#connecter">S'Inscrire</a></li>
                    <li><a href="#connecter">Se connecter</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section id="section1">
            <?php
                $data = [
                    "listOfPictures" => [
                        "../public/img/imag1.jpg",
                        "../public/img/images2.jpg",
                        "../public/img/images3.jpg",
                        "../public/img/images4.jpg"
                    ]
                ];
                $this->addModal("carousel", $data);
            ?>
        </section>
            
        <section>
            <div>
                <p>Coucou</p>
            </div>
        </section>

        <section>
            <div>
                <br>
                <br>
                <br>
                <p>coucou</p>
            </div>
        </section>
    </main>
    <footer>
        <div class="container clearfix">
            <section>
                <nav>
                    <ul>
                        <li><a href="#">Légal</a></li>
                        <li><a href="#">Cookies</a></li>
                        <li><a href="#">A propos des pubs</a></li>
                    </ul>
                </nav>
            </section>
        </div>   
    </footer>
    </body>
</html>
    