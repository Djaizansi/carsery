<?php use carsery\core\Helpers;?>
<div class="container">

    <div class="txt-center">
        <img src="./public/img/logo.png" alt="logo">
    </div>
    
    <div class="col-4 center intro box-center">

        <h1 class="txt-center">Confirmation de compte</h1>
        <p class="txt-center">Votre compte a été activé avec succès <b><?= $found->getLastname() ?></b> </b></p>
        <br><br>

        <div class="txt-center">
            <a href="<?php echo Helpers::getUrl("User", "login") ?>">Accueil</a>
        </div>
    </div>

</div>