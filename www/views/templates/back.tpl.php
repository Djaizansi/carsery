<?php use carsery\core\Helpers; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Framework CSS -->
    <link rel="stylesheet" href="../public/dist/mains.css">
    <!-- Dashboard CSS -->
    <link rel="stylesheet" href="../public/css/dashboards.css">
    <!-- Loader CSS -->
    <link rel="stylesheet" href="../public/css/loader.css">
    <link rel="stylesheet" href="../public/css/dragdrop.css">
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/42ce300797.js" crossorigin="anonymous"></script>
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- ChartJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="https://www.chartjs.org/samples/latest/utils.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <!-- Favicon -->
    <link rel="icon" href="../public/img/carsery.png">
    <!-- SCRIPTJS -->
    <script src="../public/js/user.js"></script>
    <!-- WYSIWYG -->
    <script src="https://cdn.tiny.cloud/1/vavj4oxk7dimm3sd4lw8lfnr7nk56akfvv84yc0jxo0m0cgz/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    
</head>
<body>

    <div class="grid-container">
        <div class="menu-icon">
            <i class="fas fa-bars header__menu"></i>
        </div>
    
        <header class="header">
            <div class="header__search">Bienvenue sur votre dashboard</div>
            <div class="header__avatar"><a href="<?= Helpers::getUrl("User","deconnecter")?>" style="text-decoration: none; color: #fff;">Déconnexion</a></div>
        </header>

        <aside class="sidenav">

            <div class="sidenav__close-icon">
                <i class="fas fa-times sidenav__brand-close"></i>
            </div>

            <ul class="sidenav__list">
                <li>
                    <div class="user">
                        <h1>Carsery</h1>
                        <img src="../public/img/mido.jpg" alt="User">
                        <p class="user-txt">Bonjour, <?= $firstname ?></p>
                    </div>
                </li>
                <li class="sidenav__list-item"><a href="<?= Helpers::getUrl("Dashboard","dashboard")?>"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li class="sidenav__list-item"><a href="<?= Helpers::getUrl("Page","page")?>"><i class="far fa-file"></i>Pages<i class="fas fa-chevron-right"></i></a></li>
                <li class="sidenav__list-item"><a href="<?= Helpers::getUrl("Forum","forum")?>"><i class="far fa-comments"></i>Forum<i class="fas fa-chevron-right"></i></a></li>
                <li class="sidenav__list-item"><a href="<?= Helpers::getUrl("Media","media")?>"><i class="fas fa-camera"></i>Médias<i class="fas fa-chevron-right"></i></a></li>
                <li class="sidenav__list-item"><a href="<?= Helpers::getUrl("Page","widgetPage")?>"><i class="fas fa-box"></i>Widget<i class="fas fa-chevron-right"></i></a></li>
                <hr>
                <li class="sidenav__list-item"><a href="<?= Helpers::getUrl("Apparence","apparence")?>"><i class="fas fa-palette"></i>Apparence<i class="fas fa-chevron-right"></i></a></li>
                <li class="sidenav__list-item"><a href="<?= Helpers::getUrl("User","gestionuser")?>"><i class="fas fa-user"></i>Utilisateurs<i class="fas fa-chevron-right"></i></a></li>
                <li class="sidenav__list-item"><a href="<?= Helpers::getUrl("Mail","mail")?>"><i class="far fa-envelope"></i>MailBox<i class="fas fa-chevron-right"></i></a></li>
                <li class="sidenav__list-item"><a href="<?= Helpers::getUrl("Parametre","parametre")?>"><i class="fas fa-cogs"></i>Réglages<i class="fas fa-chevron-right"></i></a></li>
            </ul>

        </aside>
        <main class="main">
            <!-- Corps du site -->
            <?php include "views/".$this->view.".view.php"; ?>
        </main>

        <footer class="footer">
            <div class="footer__copyright">&copy; 2020 Carsery</div>
            <div class="footer__signature">Projet annuel</div>
        </footer>

    </div>
    <script src="../public/js/menu.js"></script>
    <script src="../public/js/script.js"></script>
</body>
</html>