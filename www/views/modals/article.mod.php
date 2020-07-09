<?php use carsery\core\Helpers;

$forumWidget = $data;

$user = $forumWidget['user'];
$categories = $forumWidget['categories'];
$configAddArticle = $forumWidget['configAddArticle'];

?>

<div class="container">
    <div class="row">
        <h2 class="inline">Article</h2>
        <?php if($user != null && !$user->isBan()): ?>
            <button data-modal-target="modal2" class="btn btn--primary" id="myBtn" href="#myBtn">Ajouter un article</button>
        <?php endif; ?>
    </div>


    <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
        <div class="success text-center">
            <p><?=$_GET['m']?></p>
            <br>
        </div>
    <?php endif; ?>

    <?php if($categories != null):
        // ["Pneumatique" => [ {"Jante"}], ["Carrrosserie" => [ {"Bas de caisse"}, {"Parchoc"}]
        //]
        foreach ($categories as $key => $articles): ?>
            <div class="">
                <h3><?=$key?></h3>
                <?php if($articles != null): ?>
                    <?php foreach ($articles as $article): ?>
                        <div class="article">
                            <p><b>Titre:</b> <a href="<?php echo Helpers::getUrl("Front", "readarticle") ?>?id=<?= $article->getId() ?>"><?=$article->getTitle()?></a></p>
                            <p><b>Description:</b> <?=$article->getDescription()?></p>
                            <p class="text-right">
                                <?php if(($user->getId() == $article->getAuthor()->getId()) || $user->getStatus() == 'Admin'): ?>
                                    <?php if(!$article->isResolve()): ?>
                                        <a href="#" title="Résolution" data-modal-target="modal3" data-id="<?= $article->getId() ?>" class="cursor btnResolve" ><i class="fas fa-check-square"></i></a>
                                    <?php endif; ?>
                                    <a title="Modification" href="<?php echo Helpers::getUrl("Front", "updatearticleview") ?>?id=<?= $article->getId() ?>"><i class="fas fa-edit"></i></a>
                                <?php endif; ?>
                                <?php if($user->getStatus() == 'Admin'): ?>
                                    <a title="Suppression" href="#" data-modal-target="modal1" data-model="article" data-id="<?= $article->getId() ?>" class="cursor btnDelete"><i class="fas fa-trash-alt"></i></a>
                                <?php endif; ?>
                            </p>
                        </div>
                        <br>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <br>
        <?php endforeach; ?>
    <?php endif; ?>


    <?php if($user != null && !$user->isBan()): ?>
        <div class="modal" id="modal2"> <!-- This is the background overlay -->
            <div class="modal-content"> <!-- This is the actual modal/popup box -->
                <span class="modal-close">&times;</span>
                <h2 class="txt-center">Création d'un article</h2>
                <?php $this->addModal("form", $configAddArticle); ?>
            </div>
        </div>

        <div class="modal" id="modal1"> <!-- This is the background overlay -->
            <div class="modal-content"> <!-- This is the actual modal/popup box -->
                <span class="modal-close">&times;</span>
                <p>Souhaitez-vous vraiment supprimer cette article?</p>
                <form method="POST"  action="<?php echo Helpers::getUrl("Front", "removearticle") ?>">
                    <input type="hidden" id="idToDelete" name="id">
                    <button type="submit" id="yesBtnD" class="btn btn--success">Oui</button>
                    <button type="button" class="btn btn--danger btnNo">Non</button>
                </form>
            </div>
        </div>

        <div class="modal" id="modal3"> <!-- This is the background overlay -->
            <div class="modal-content"> <!-- This is the actual modal/popup box -->
                <span class="modal-close">&times;</span>
                <p>Souhaitez-vous vraiment marqué cette article comme résolu ?</p>
                <form method="POST"  action="<?php echo Helpers::getUrl("Front", "resolvearticle") ?>">
                    <input type="hidden" id="idToResolve" name="id">
                    <button type="submit" id="yesBtnR" class="btn btn--success">Oui</button>
                    <button type="button" class="btn btn--danger btnNo">Non</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>