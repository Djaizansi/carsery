<?php use carsery\core\Helpers; ?>

<div class="container">

    <div class="col-4 intro box-center">

        <?php if(!empty($errors)): ?>
				<div class="alert alert--danger">
					<?php foreach($errors as $uneErreur): ?>
						<p> <?=$uneErreur?> </p>
					<?php endforeach ?>
				</div>
        <?php endif ?>
        
        <h1>Connexion</h1>
        <?php $this->addModal("form", $configFormUser );?>

        <div class="txt-center">
            <a href="<?php echo Helpers::getUrl("User", "register") ?>">Sign up</a>
            <br>
            <a href="<?php echo Helpers::getUrl("User", "forget") ?>">Mot de passe oublié ?</a>
        </div>
        
    </div>

</div>