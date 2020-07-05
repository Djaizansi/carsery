<?php use carsery\core\Helpers; ?>

<div class="container">
    <div class="row text-center">
        <h2 class="inline">Modification de message</h2>
        <a class="btn btn--primary" id="myBtn" href="<?php echo Helpers::getUrl("Forum", "forum") ?>"><i class="fas fa-arrow-left"></i></a>
    </div>
</div>

<div class="container">
    <?php $this->addModal("form", $configUpdateMessage); ?>
</div>