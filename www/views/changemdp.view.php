<?php use carsery\core\Helpers; ?>

<div class="container">

    <div class="txt-center">
        <img src="./public/img/logo.png" alt="logo">
    </div>

    <div class="col-4 center intro box-center">
        <?php if(!empty($errors)): ?>
            <div class="alert alert--danger">
                <?php foreach($errors as $uneErreur): ?>
                    <p> <?=$uneErreur?> </p>
                <?php endforeach ?>
            </div>
        <?php endif ?>
        <h1 class="txt-center">Mot de passe oublié</h1>
        <p class="txt-center">Nouveau mot de passe pour <b><?= $_SESSION['email'] ?></b></p>
        <br><br>
        <?php $this->addModal("form", $configFormPwd );?>
    
        <div class="txt-center">
            <a href="<?php echo Helpers::getUrl("User", "login") ?>">Accueil</a>
        </div>
    </div>

</div>