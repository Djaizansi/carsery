<?php use carsery\core\Helpers; ?>

<div class="container">
    <div class="row">
        <h2 class="inline">Article</h2>
        <!--         <a class="btn btn--primary" style="font-size: 0.7rem !important;" href="/ajouter-page">Ajouter</a> -->
        <button data-modal-target="modal2" class="btn btn--primary" id="myBtn" href="#myBtn">Ajouter</button>
    </div>
</div>

<div class="container">
    <table id="myTable" class="display">
        <thead>
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Catégorie</th>
            <th>Résolu</th>
            <th>Date de création</th>
            <th style="width: 30px;">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($articles as $article): ?>
            <tr id="article-<?= $article->getId() ?>">
                <td><a href="<?php echo Helpers::getUrl("Forum", "readarticle") ?>?id=<?=$article->getId()?>"><?= $article->getTitle() ?></a></td>
                <td><?= $article->getDescription() ?></td>
                <td><?= $article->getCategory()->getName() ?></td>
                <td><?= ($article->isResolve()) ? 'Oui' : 'Non' ;?></td>
                <?php $dateC = new DateTime($article->getCreationDate()) ?>
                <td><?= $dateC->format('d/m/Y') ?></td>
                <td>
                    <?php if($user->getId() == $article->getAuthor()->getId()): ?>
                        <?php if(!$article->isResolve()): ?>
                            <a href="#" title="Résolution" data-modal-target="modal3" data-id="<?= $article->getId() ?>" class="cursor btnResolve" ><i class="fas fa-check-square"></i></a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <a title="Modification" href="<?php echo Helpers::getUrl("Forum", "updatearticleview") ?>?id=<?= $article->getId() ?>"><i class="fas fa-edit"></i></a>
                    <?php if($user->getStatus() == 'Admin'): ?>
                        <a title="Suppression" href="#" data-modal-target="modal1" data-id="<?= $article->getId() ?>" class="cursor btnDelete"><i class="fas fa-trash-alt"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>

<div class="modal" id="modal1"> <!-- This is the background overlay -->
    <div class="modal-content"> <!-- This is the actual modal/popup box -->
        <span class="modal-close">&times;</span>
        <p>Souhaitez-vous vraiment supprimer cette article?</p>
        <form method="POST"  action="<?php echo Helpers::getUrl("Forum", "removearticle") ?>">
            <input type="hidden" id="idToDelete" name="id">
            <button type="submit" id="yesBtnD" class="btn btn--success">Oui</button>
            <button type="button" class="btn btn--danger btnNo">Non</button>
        </form>
    </div>
</div>

<div class="modal" id="modal2"> <!-- This is the background overlay -->
    <div class="modal-content"> <!-- This is the actual modal/popup box -->
        <span class="modal-close">&times;</span>
        <h2 class="txt-center">Création d'un article</h2>
        <?php $this->addModal("form", $configAddArticle); ?>
    </div>
</div>

<div class="modal" id="modal3"> <!-- This is the background overlay -->
    <div class="modal-content"> <!-- This is the actual modal/popup box -->
        <span class="modal-close">&times;</span>
        <p>Souhaitez-vous vraiment marqué cette article comme résolu ?</p>
        <form method="POST"  action="<?php echo Helpers::getUrl("Forum", "resolvearticle") ?>">
            <input type="hidden" id="idToResolve" name="id">
            <button type="submit" id="yesBtnR" class="btn btn--success">Oui</button>
            <button type="button" class="btn btn--danger btnNo">Non</button>
        </form>
    </div>
</div>

</div>

</div>