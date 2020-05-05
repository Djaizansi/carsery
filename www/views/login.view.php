<?php use carsery\core\Helpers; ?>

<div class="container">
    <h1>Connexion</h1>
    <?php $this->addModal("form", $configFormUser );?>
    <div class="text-center">
        <a class="small" href="<?php echo Helpers::getUrl("User", "register") ?>">Sign up</a>
        <br>
        <a class="small" href="<?php echo Helpers::getUrl("User", "forget") ?>">Mot de passe oublié ?</a>
    </div>
</div>

