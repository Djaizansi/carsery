<?php
$listPage = $page->find('*');
$listPageCree = $page->find('*', 'publie', 0);
$listPagePubliee = $page->find('*', 'publie', 1);

!empty($listPage) ? $tabTotal[] = $listPage : $tabTotal = [];
!empty($listPageCree) ? $tabCreeTotal[] = $listPageCree : $tabCreeTotal = [];
!empty($listPagePubliee) ? $tabPublieTotal[] = $listPagePubliee : $tabPublieTotal = [];


$total = count($listPage) <= 1 ? count($tabTotal) : count($listPage);
$cree = count($listPageCree) <= 1 ? count($tabCreeTotal) : count($listPageCree);
$publie = count($listPagePubliee) <= 1 ? count($tabPublieTotal) : count($listPagePubliee);


$donnee = count($listPage) > 1 ? $listPage : $tabTotal;
$tri = isset($_GET['champ']) ? $_GET['champ'] : '';

if(count($listPage) < 1){
    $donnee = $tabTotal;
}else{
    $donnee = $listPage;
}

if($tri === 'cree'){
    if(is_array($listPageCree) && count($listPageCree) > 1){
        $donnee = $listPageCree;
    }else {
        $donnee = $tabCreeTotal;
    }
}elseif($tri === 'publie'){
    if(is_array($listPagePubliee) && count($listPagePubliee) > 1){
        $donnee = $listPagePubliee;
    }else {
        $donnee = $tabPublieTotal;
    }
}

/* $tri === 'total' ? $donnee = $listPage : '';
$tri === 'cree' ? $donnee = $listPageCree : '';
$tri === 'publie' ? $donnee = $tabPublieTotal : ''; */


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
                        <?php $url = str_replace(' ','-',strtolower($titre)) ?>
                        
                        <td><a href="<?=$url?>"><?=$titre?></a></td>
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
                            <button data-modal-target="modal1" data-id="<?= $unePage->getId() ?>" class="myBtn" id="myBtn" href="#myBtn"><i class="fas fa-trash-alt"></i></button>
                            
                        </td>
                    </tr>
                <?php endforeach ?>
        </tbody>
    </table>
</div>

    <div class="modal" id="modal1"> <!-- This is the background overlay -->
        <div class="modal-content"> <!-- This is the actual modal/popup box -->
            <span class="modal-close">&times;</span>
            <p>Souhaitez-vous vraiment supprimer cette ?</p>
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