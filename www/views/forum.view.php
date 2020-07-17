<?php use carsery\core\Helpers; ?>

<div class="container">
    <div class="row">
        <?php if(isset($_SESSION['reussite']) && $_SESSION['reussite'] == "deletemessage"): ?>
            <?= Helpers::alert('success','',"Le message a bien été supprimé") ?>
        <?php else: ?>
        <?php endif ?>
        
        <?php unset($_SESSION['reussite']) ?>

        <h2 class="inline">Article</h2>
        <?php if(!$user->isBan()): ?>
            <button data-modal-target="modal2" class="btn btn--primary" id="myBtn" href="#myBtn">Ajouter un article</button>
            <?php if($user->getStatus() == 'Admin'): ?>
                <button data-modal-target="modal5" class="btn btn--primary" id="myBtn" href="#myBtn">Ajouter une catégorie</button>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<div class="container">

    <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
        <div class="success text-center">
            <p><?=$_GET['m']?></p>
            <br>
        </div>
    <?php endif; ?>


    <?php if($user->getStatus() == 'Admin'): ?>
        <?php if ($categories != null): ?>
            <table id="myTable2" class="display">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th style="width: 30px;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr id="category-<?= $category->getId() ?>">
                        <td><span><?= $category->getName() ?></span></td>
                        <td>
                            <a title="Modification" href="<?php echo Helpers::getUrl("Forum", "updatecategoryview") ?>?id=<?= $category->getId() ?>"><i class="fas fa-edit"></i></a>
                            <a title="Suppression" href="#" data-modal-target="modal4" data-id="<?= $category->getId() ?>" class="cursor btnDelete"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune catégorie</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<div class="container">
    <?php if ($articles != null): ?>
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
                        <?php if(($user->getId() == $article->getAuthor()->getId()) || $user->getStatus() == 'Admin'): ?>
                            <?php if(!$article->isResolve()): ?>
                                <a href="#myBtn" title="Résolution" data-modal-target="modal3" data-id="<?= $article->getId() ?>" class="myBtn" ><i class="fas fa-check-square"></i></a>
                            <?php endif; ?>
                            <a title="Modification" href="<?php echo Helpers::getUrl("Forum", "updatearticleview") ?>?id=<?= $article->getId() ?>"><i class="fas fa-edit"></i></a>
                        <?php endif; ?>
                        <?php if($user->getStatus() == 'Admin'): ?>
                            <a title="Suppression" href="#" data-modal-target="modal1" data-model="article" data-id="<?= $article->getId() ?>" class="cursor btnDelete"><i class="fas fa-trash-alt"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun article</p>
    <?php endif; ?>
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
        <?php $this->addModal("form2", $configAddArticle); ?>
    </div>
</div>

<div class="modal" id="modal5"> <!-- This is the background overlay -->
    <div class="modal-content"> <!-- This is the actual modal/popup box -->
        <span class="modal-close">&times;</span>
        <h2 class="txt-center">Création d'une catégorie</h2>
        <?php $this->addModal("form2", $configAddCategory); ?>
    </div>
</div>

<div class="modal" id="modal3"> <!-- This is the background overlay -->
    <div class="modal-content"> <!-- This is the actual modal/popup box -->
        <span class="modal-close">&times;</span>
        <p>Souhaitez-vous vraiment résoudre cet article?</p>
        <a id="btnYesResolve" class="btn btn--success">Oui</a>
        <a id="btnNo" class="btn btn--danger">Non</a>
    </div>
</div>

<div class="modal" id="modal4"> <!-- This is the background overlay -->
    <div class="modal-content"> <!-- This is the actual modal/popup box -->
        <span class="modal-close">&times;</span>
        <p>Souhaitez-vous vraiment supprimer cette catégorie ?</p>
        <form method="POST"  action="<?php echo Helpers::getUrl("Forum", "removecategory") ?>">
            <input type="hidden" id="idToDeleteC" name="id">
            <button type="submit" id="yesBtnC" class="btn btn--success">Oui</button>
            <button type="button" class="btn btn--danger btnNo">Non</button>
        </form>
    </div>
</div>