<?php use carsery\core\Helpers; ?>

<div class="col-4 intro box-center">
    <?php if(!empty($errors)): ?>
        <div class="alert alert--danger">
            <?php foreach($errors as $uneErreur): ?>
                <p> <?=$uneErreur?> </p>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <h1>Inscription</h1>

    <?php $this->addModal("form", $configFormUser );?>

    <div class="txt-center">
        <a href="<?php echo Helpers::getUrl("User", "login") ?>">Sign in</a>
    </div>
    
</div>

<script>document.getElementById('idPwdConfirm').onpaste = function(){
        alert('Merci de ne pas copier/coller');        // on prévient
        return false;        // on empêche
    };
</script>