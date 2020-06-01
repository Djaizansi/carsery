<?php
$listPage = $pageManager->findAll();
$listPageCree = $pageManager->findBy(['publie' => 0]);
$listPagePubliee = $pageManager->findBy(['publie' => 1]);

$total = count($listPage);
$cree = count($listPageCree);
$publie = count($listPagePubliee);


$donnee = $listPage;
$tri = isset($_GET['champ']) ? $_GET['champ'] : '';

($tri === 'cree') ? $donnee = $listPageCree : '';
($tri === 'publie') ? $donnee = $listPagePubliee : '';

?>
<div class="container">
    <div class="row">
        <h2 class="inline">Pages</h2>
<!--         <a class="btn btn--primary" style="font-size: 0.7rem !important;" href="/ajouter-page">Ajouter</a> -->
        <button data-modal-target="modal2" class="btn btn--primary" id="myBtn" href="#myBtn">Ajouter</button>
    </div>
    <a href="/page" class="inline">Tous (<?= $total ?>)</a>
    <p class="inline">|</p>
    <a href="/page?champ=cree" class="inline">Non Publiées (<?= $cree ?>)</a>
    <p class="inline">|</p>
    <a href="/page?champ=publie" class="inline">Publiées (<?= $publie ?>)</a>
</div>

<div class="container">
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>Uri</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Date</th>
                <th>Publiée</th>
                <th style="width: 30px;">Action</th>
            </tr>
        </thead>
        <tbody>
                <?php foreach($donnee as $unePage): ?>
                    <tr>

                        <?php $unTitre = $unePage->getTitre() ?>
                        <?php $titre = isset($unTitre) ? $unTitre : '' ?>
                        <?php $url = "/myproject".$unePage->getUri() ?>
                        <td><a href="<?=$url?>"><?=$url?></a</td>
                        <td><?=$titre?></td>
                        <td><?= $unePage->getAuteur() ?></td>
                            <td>
                            <?php if($unePage->getPublie() == 0): ?>
                                Créé le 
                            <?php elseif($unePage->getPublie() == 1): ?>
                                Publié le 
                            <?php endif ?>
                                <?php $date = new DateTime($unePage->getDate())?>
                                <?= $date->format('d/m/Y') ?>
                            </td>
                        <?php if($unePage->getPublie() == 0): ?>
                            <td>Non Publié</td>

                        <?php elseif($unePage->getPublie() == 1): ?>
                            <td>Publié</td>
                        <?php endif ?>
                        <td>
                            <!-- <a href="/modifier_page"><i class="fas fa-edit"></i></a> --> 
                            <button data-modal-target="modal1" data-id="<?= $unePage->getId() ?>" data-token="<?= $unePage->getToken() ?>" class="myBtn" id="myBtn" href="#myBtn"><i class="fas fa-trash-alt"></i></button>
                            <a href="/edit-page?id=<?=$unePage->getId()?>"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
        </tbody>
    </table>
</div>

    <div class="modal" id="modal1"> <!-- This is the background overlay -->
        <div class="modal-content"> <!-- This is the actual modal/popup box -->
            <span class="modal-close">&times;</span>
            <p>Souhaitez-vous vraiment supprimer cette page?</p>
			<a id="btnYes" class="btn btn--success">Oui</a>
			<a id="btnNo" class="btn btn--danger">Non</a>
        </div>
    </div>

    <div class="modal" id="modal2"> <!-- This is the background overlay -->
        <div class="modal-content"> <!-- This is the actual modal/popup box -->
            <span class="modal-close">&times;</span>
            <h2 class="txt-center">Création de page</h2>
            <?php $this->addModal("form", $configFormPage );?>
        </div>
    </div>