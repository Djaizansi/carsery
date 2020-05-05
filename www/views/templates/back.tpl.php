<?php use carsery\core\Helpers; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carsery</title>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/42ce300797.js" crossorigin="anonymous"></script>
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- DataTable-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="public/js/datatable.js"></script>
    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    <script src="public/js/stats.js"></script>
    <!-- Fichier CSS personnalisée -->
    <link rel="stylesheet" href="../public/dist/main.css">
    <link rel="stylesheet" href="../public/dist/loader.css">
    <link rel="icon" href="../public/img/carsery.png">
    <!-- SCRIPTJS -->
    <script src="../public/js/script.js"></script>
</head>
<body>

    <!-- NAVBAR -->
    <header class="header">
        <div class="title">
            <h1>CARSERY</h1>
        </div>
        <nav>
            <ul>
                <li><a>DASHBOARD</a></li>
                <li><input type="text" class="input_search"><a href="#"><i class="fas fa-search"></i></a></li>
                <li><a class="style_barre">|</a></li>
                <li><a href="#"><i class="fas fa-bell"></i></a></li>
                <li><a class="style_barre">|</a></li>
                <li><a href="#"><i class="fas fa-envelope"></i></a></li>
                <li><a class="style_barre">|</a></li>
                <li><a href="#"><i class="fas fa-money-check-alt"></i></a></li>
                <li><a class="style_barre">|</a></li>
                <li><a href="#"><i class="fas fa-user"></i></a></li>
                <li><a class="style_barre">|</a></li>
                <li><a href="/deconnexion"><i class="fas fa-power-off"></i></a></li>
            </ul>
        </nav>
    </header>
    <main class="container">
        <!-- SIDEBAR -->
        <div class="item1 sidebar">
            <div class="user">
                <img class="image" src="/public/img/mido.jpg" alt="user">
                <p>Hi,</p>
                <p><?= $firstname ?></p>
            </div>
            <ul>
                <li><a href="<?= Helpers::getUrl("Dashboard","dashboard")?>"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a href="<?= Helpers::getUrl("Page","page")?>"><i class="far fa-file"></i>Pages<i class="fas fa-chevron-right"></i></a></li>
                <li><a href="<?= Helpers::getUrl("Forum","forum")?>"><i class="far fa-comments"></i>Forum<i class="fas fa-chevron-right"></i></a></li>
                <li><a href="<?= Helpers::getUrl("Media","media")?>"><i class="fas fa-camera"></i>Médias<i class="fas fa-chevron-right"></i></a></li>
                <li><a href="<?= Helpers::getUrl("Page","lien")?>"><i class="fas fa-link"></i>Liens<i class="fas fa-chevron-right"></i></a></li>
                <hr>
                <li><a href="<?= Helpers::getUrl("Apparence","apparence")?>"><i class="fas fa-palette"></i>Apparence<i class="fas fa-chevron-right"></i></a></li>
                <li><a href="<?= Helpers::getUrl("User","gestionuser")?>"><i class="fas fa-user"></i>Utilisateurs<i class="fas fa-chevron-right"></i></a></li>
                <li><a href="<?= Helpers::getUrl("Mail","mail")?>"><i class="far fa-envelope"></i>MailBox<i class="fas fa-chevron-right"></i></a></li>
                <li><a href="<?= Helpers::getUrl("Parametre","parametre")?>"><i class="fas fa-cogs"></i>Réglages<i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </div>


        <!-- Corps du site -->
        <?php include "views/".$this->view.".view.php"; ?>
    </main>
</body>
</html>