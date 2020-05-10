<?php
$listPage = $page->find('*');
$listPageCree = $page->find('*', 'publie', 0);
$listPagePubliee = $page->find('*', 'publie', 1);

$tabTotal[] = $listPage;
$tabCreeTotal[] = $listPageCree;
$tabPublieTotal[] = $listPagePubliee;


$total = count($listPage) <= 1 ? count($tabTotal) : count($listPage);
$cree = count($listPageCree) <= 1 ? count($tabCreeTotal) : count($listPageCree);
$publie = count($listPagePubliee) <= 1 ? count($tabPublieTotal) : count($listPagePubliee);
$tri = $_GET['champ'];


if($tri === 'total'){
    if(is_array($listPage) && count($listPage) > 1){
        $donnee = $listPage;
    }else {
        $donnee = $tabTotal;
    }
}elseif($tri === 'cree'){
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
        <a class="btn btn--primary" style="font-size: 0.7rem !important;" href="/ajouter-page">Ajouter</a>
    </div>
    <a href="/page?champ=total" class="inline">Tous (<?= $total ?>)</a>
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
                <th>Publié</th>
                <th style="width: 30px;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($donnee as $unePage): ?>
                <tr>
                    <td><?= $unePage->getTitre() ?></td>
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
                    <td><a href="/modifier_page"><i class="fas fa-edit"></i></a> <a href="supprimer_page"><i class="fas fa-trash-alt"></i></a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>