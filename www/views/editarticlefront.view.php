<?php use carsery\core\Helpers; ?>

<div class="container">
    <div class="row text-center">
        <h2 class="inline">Modification d'article</h2>
        <a class="btn btn--primary" id="myBtn" href="<?php echo Helpers::getUrl("Front", "frontforum") ?>"><i class="fas fa-arrow-left"></i></a>
    </div>
</div>

<div class="container">
    <?php $this->addModal("form", $configAddArticle); ?>
</div>