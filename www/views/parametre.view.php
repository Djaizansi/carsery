<?php 
use carsery\core\Helpers;
use carsery\core\Session;
?>


<div class="container">
    <?php if(!empty($errors)): ?>
        <?= Helpers::alert('danger',$errors); ?>
    <?php elseif(isset($_SESSION['success']) && $_SESSION['success'] == 'updateProfile'): ?>
        <?= Helpers::alert('success','',"L'utilisateur a bien été modifié"); ?>
        <?php unset($_SESSION['success']); ?>
    <?php endif ?>

    <?php if(Session::estAdmin()): ?>
        <h1>Informations du CMS</h1>
        <p>Retrouver ici toutes les informations.</p>

        <div class="row txt-center">
            <div class="col-4">
                <a class="myBtn" id="myBtn" href="#myBtn" data-modal-target='modal1'>
                    <div class="card-theme">
                        <img src="../public/img/user_default.png" alt="User" style="width:90%">
                        <div class="card-theme-info">
                            <h4>
                                <b>Compte</b>
                            </h4>
                            <p>Récapitulatif du compte</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-4">
                <a class="myBtn" id="myBtn" href="#myBtn" data-modal-target='modal2'>
                    <div class="card-theme">
                        <img src="../public/img/logo.png" alt="Carsery" style="width:90%">
                        <div class="card-theme-info">
                            <h4>
                                <b>Carsery</b>
                            </h4>
                            <p>Informations du CMS</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-4">
                <a class="myBtn" id="myBtn" href="#myBtn" data-modal-target='modal3'>
                    <div class="card-theme">
                        <img src="../public/img/team.jpg" alt="Carsery" style="width:90%">
                        <div class="card-theme-info">
                            <h4>
                                <b>Le groupe</b>
                            </h4>
                            <p>Collaborateurs de Carsery</p>
                        </div>
                    </div>
                </a>
            </div>
            <br>
        </div>
    <?php endif ?>

    <div>
        <br>
        <h3 class="text-center" style= " <?= Session::estClient() ? 'color: black;' : '' ?> " >Profile</h3>
        <?= $this->addModal('form',$configFormProfile) ?>
    </div>

    <?php if(Session::estAdmin()): ?>

        <div class="modal" id="modal1">
            <!-- This is the background overlay -->
            <div class="modal-content">
                <!-- This is the actual modal/popup box -->
                <span class="modal-close">&times;</span>
                <h1>Compte - <?= $firstname; ?></h1>
                <p>Accèder au gestionnaire pour avoir un aperçu du compte <?= $firstname; ?></p>
                <a href="<?= Helpers::getUrl('User','gestionuser') ?>" class="btn btn--primary">Accèder au gestionnaire</a>
            </div>
        </div>

        <div class="modal" id="modal2">
            <div class="modal-content">
                <span class="modal-close">&times;</span>
                <h1>Carsery</h1>

                <?php if (!isset($msg)) { ?>

                    <h2>Base de données</h2>
                    <ul class="check-list">
                        <li>Driver : <?= DBDRIVER; ?></li>
                        <li>Adresse : <?= DBHOST; ?></li>
                        <li>Nom : <?= DBNAME; ?> </li>
                        <li>Utilisateur : <?= DBUSER; ?></li>
                        <li>Mot de passe : ******</li>
                    </ul>

                    <h2>Site</h2>
                    <ul class="check-list">
                        <li>Nom du site : <?= WEBSITE_TITLE; ?></li>
                        <li>Description : <?= DESCRIPTION; ?></li>
                    </ul>

                <?php } else {
                    echo $msg;
                }
                ?>

                <h2>CMS</h2>
                <ul class="check-list">
                    <li>Version : 1.0.0</li>
                    <li>Langue : Français</li>
                </ul>
            </div>
        </div>

        <div class="modal" id="modal3">
            <div class="modal-content">
                <span class="modal-close">&times;</span>
                <h1>Membres du groupe Carsery</h1>
                <div class="row txt-center">
                    <div class="col-3">
                        <div class="card-carsery">
                            <img src="../public/img/carsery-team.png" alt="John" style="width:100%">
                            <h1>BOUABDELLAH Marwane</h1>
                            <p class="title-carsery">IW3-1</p>
                            <div style="margin: 24px 0;">
                                <img src="../public/img/esgi.jpg" style="width:30%">
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card-carsery">
                            <img src="../public/img/carsery-team.png" alt="John" style="width:100%">
                            <h1>JALLALI Youcef</h1>
                            <p class="title-carsery">IW3-1</p>
                            <div style="margin: 24px 0;">
                                <img src="../public/img/esgi.jpg" style="width:30%">
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card-carsery">
                            <img src="../public/img/carsery-team.png" alt="John" style="width:100%">
                            <h1>WELLE Guillaume</h1>
                            <p class="title-carsery">IW3-1</p>
                            <div style="margin: 24px 0;">
                                <img src="../public/img/esgi.jpg" style="width:30%">
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card-carsery">
                            <img src="../public/img/carsery-team.png" alt="John" style="width:100%">
                            <h1>TEBAILI Nesrine</h1>
                            <p class="title-carsery">IW3-1</p>
                            <div style="margin: 24px 0;">
                                <img src="../public/img/esgi.jpg" style="width:30%">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card-carsery mel">
                            <img src="../public/img/carsery-team.png" alt="John" style="width:100%">
                            <h1>DISPAGNE Mel</h1>
                            <p class="title-carsery">IW3-1</p>
                            <div style="margin: 24px 0;">
                                <img src="../public/img/esgi.jpg" style="width:30%">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php endif ?>


</div>