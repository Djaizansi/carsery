
<?php 
use carsery\core\Helpers;
?>

<div class="container">

    <div class="col-4 intro box-center">

        <?php if(!empty($errors)): ?>
				<div class="alert alert--danger">
					<?php foreach($errors as $uneErreur): ?>
						<p> <?=$uneErreur?> </p>
					<?php endforeach ?>
				</div>
        <?php endif ?>

        
        <?php if(!empty($_SESSION['success']) && $_SESSION['success'] === 1): ?>
            <div class="alert alert--success">
                <p>Un email de confirmation vous a été envoyé !</p>
            </div>
        <?php endif ?>
        <?php $_SESSION['success'] = '' ?>
        
        
        <h1>Connexion</h1>
        <?php $this->addModal("form", $configFormUser );?>

        <div class="txt-center">
            <a href="<?php echo Helpers::getUrl("User", "register") ?>">Sign up</a>
            <br>
            <a href="<?php echo Helpers::getUrl("User", "forget") ?>">Mot de passe oublié ?</a>
        </div>
        
    </div>

</div>