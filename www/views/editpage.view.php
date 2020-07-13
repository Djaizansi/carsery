<?php

use carsery\core\Helpers;

$pageFound = $pageManager->find($_GET['id']);
$titre = $pageFound->getTitre();
?>

    <div class="container">
        <?php if(isset($errors) && !empty($errors)): ?>
            <?= Helpers::alert('danger',$errors);?>
        <?php endif ?>
        
        <h2>Editer la page : <?= $titre ?></h2>
        <?php $this->addModal("form", $configFormPage );?>
    </div>
