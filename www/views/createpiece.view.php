<?php use carsery\core\Helpers; ?>
<div class="container">


        <?php if(!empty($errors)): ?>
            <div class="alert alert--danger">
                <?php foreach($errors as $uneErreur): ?>
                    <p> <?=$uneErreur?> </p>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    

    <?php $this->addModal("form", $configFormCreatePiece);?>


    <div class="txt-center">
        <a href="<?php echo Helpers::getUrl("Piece", "piece") ?>">Return to list of pieces</a>
    </div>
    

</div>
