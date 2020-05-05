<?php use carsery\core\Helpers; ?>

<div class="container">
    <h1>Mot de passe oublié</h1>

        Récupération de mot de passe pour <?= $_SESSION['email'] ?>
        <br><br>
        <?php $this->addModal("form", $configFormRecup );?>
        
    <div class="text-center">
        <a class="small" href="<?php echo Helpers::getUrl("User", "login") ?>">Accueil</a>
    </div>
</div>