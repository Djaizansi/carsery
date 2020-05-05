<?php use carsery\core\Helpers; ?>

<div class="container">
    <h1>Inscription</h1>
    <?php $this->addModal("form", $configFormUser );?>
    <div class="text-center">
        <a class="small" href="<?php echo Helpers::getUrl("User", "login") ?>">Sign in</a>
    </div>
</div>

<script>document.getElementById('idPwdConfirm').onpaste = function(){
        alert('Merci de ne pas copier/coller');        // on prévient
        return false;        // on empêche
    };
</script>