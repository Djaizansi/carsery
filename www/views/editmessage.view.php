<?php use carsery\core\Helpers;
use carsery\core\Session;

?>

<div class="container">
    <div class="row text-center">
        <h2 class="inline">Modification de message</h2>
        <?php if(Session::estClient()): ?>
            <a class="btn btn--primary" id="myBtn" href="javascript:history.back()"><i class="fas fa-arrow-left"></i></a>
        <?php elseif(Session::estAdmin()): ?>
            <a class="btn btn--primary" id="myBtn" href="<?php echo Helpers::getUrl("Forum", "forum") ?>"><i class="fas fa-arrow-left"></i></a>
        <?php endif ?>
    </div>
</div>

<div class="container">
    <?php $this->addModal("form2", $configUpdateMessage); ?>
</div>