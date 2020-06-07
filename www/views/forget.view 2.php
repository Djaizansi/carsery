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
        <p class="txt-center">Saissisez votre adresse mail ci-dessous pour réinitialiser votre mot de passe.</p>
        <?php $this->addModal("form", $configFormUser );?>

        <div class="txt-center">
            <a href="<?php echo Helpers::getUrl("User", "login") ?>">Accueil</a>
        </div>
    </div>

</div>