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
        
        <h2>Shortcode</h2>
        <table id="myTable" class="display">
            <thead>
                <th>Shortcode</th>
                <th>Description</th>
                <th>Type</th>
            </thead>
            <tbody>
                <?php foreach($findAllShort as $unCode): ?>
                <tr>
                    <td><?=$unCode->getShortcode()?></td>
                    <td><?=$unCode->getDescription()?></td>
                    <td><?=$unCode->getType()?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
