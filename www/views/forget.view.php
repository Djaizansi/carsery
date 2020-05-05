<?php use carsery\core\Helpers; ?>

<div class="container">
    <h1>Mot de passe oublié</h1>

        <?php $this->addModal("form", $configFormUser );?>
        
    <div class="text-center">
        <a class="small" href="<?php echo Helpers::getUrl("User", "login") ?>">Accueil</a>
    </div>
</div>