<?php use carsery\core\Helpers; ?>
<div class="container">

   <?php if(!empty($errors)): ?>
            <div class="alert alert--danger">
                <?php foreach($errors as $uneErreur): ?>
                    <p> <?=$uneErreur?> </p>
                <?php endforeach ?>
            </div>
        <?php endif ?>

 <h2>Add an Voiture</h2>

    <?php $this->addModal("form", $configFormCreateVoiture);?>


    <div class="txt-center">
        <a href="<?php echo Helpers::getUrl("Voiture", "retrieveVoitures") ?>">Return to list of car</a>
    </div>
    

    

</div>
