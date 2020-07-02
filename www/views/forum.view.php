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
                <th>Date de création</th>
                <th style="width: 30px;">Action</th>
            </tr>
        </thead>
        <tbody>
                <?php foreach($articles as $article): ?>
                    <tr id="article-<?=$article->getId()?>">
                        <td><a href="<?php echo Helpers::getUrl("Forum", "readarticle") ?>"><?=$article->getTitle()?></a></td>
                        <td><?=$article->getDescription()?></td>
                        <?php $dateC = new DateTime($article->getCreationDate())?>
                        <td><?=$dateC->format('d/m/Y')?></td>
                        <td>
                            <form method="POST" action="<?php echo Helpers::getUrl("Forum", "removearticle") ?>">
                                <input type="hidden" name="id" value="<?= $article->getId() ?>">
                                <button data-modal-target="modal1" name="delete" data-id="<?= $article->getId() ?>" class="myBtn" id="myBtn" href="#myBtn"><i class="fas fa-trash-alt"></i></button>
                            </form>
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
			<a id="btnYes" data-id class="btn btn--success">Oui</a>
			<a id="btnNo" class="btn btn--danger">Non</a>
        </div>
    </div>

    <div class="modal" id="modal2"> <!-- This is the background overlay -->
        <div class="modal-content"> <!-- This is the actual modal/popup box -->
            <span class="modal-close">&times;</span>
            <h2 class="txt-center">Création d'un article</h2>
            <?php $this->addModal("form", $configAddArticle );?>
        </div>
    </div>
    </div>

</div>

<script>
    var yesButton = document.getElementById("btnYes");
    yesButton.addEventListener('click', function () {
        
    });
</script>