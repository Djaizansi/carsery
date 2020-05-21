<?php
$pageFound = $pageManager->find($_GET['id']);
$titre = $pageFound->getTitre();
$file = file_get_contents("Views/$titre.view.php");
?>

    <div class="container">
        <h2>Editer la page : <?= $titre ?></h2>
        <?php $this->addModal("form", $configFormPage );?>
    </div>