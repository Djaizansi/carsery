<?php
$pageFound = $pageManager->find($_GET['id']);
$titre = $pageFound->getTitre();
$notiret = str_replace(' ','',strtolower($titre));
$file = file_get_contents("Views/$notiret.view.php");
?>

    <div class="container">
        <h2>Editer la page : <?= $titre ?></h2>
        <?php $this->addModal("form", $configFormPage );?>
    </div>