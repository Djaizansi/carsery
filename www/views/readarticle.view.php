<?php use carsery\core\Helpers; ?>

<div class="container">
    <div class="row text-center">
        <h2 class="inline">Article</h2>
        <a class="btn btn--primary" id="myBtn" href="<?php echo Helpers::getUrl("Forum", "forum") ?>"><i class="fas fa-arrow-left"></i></a>
    </div>
</div>

<div class="container">
    <div class="row">
        <p><b>Titre:</b> <?=$article->getTitle() ?></p>
        <p><b>Description:</b> <?=$article->getDescription() ?></p>
        <?php $a = new DateTime($article->getCreationDate()) ?>
        <p><b>Date de création:</b> <?=$a->format('d/m/Y H:i:s'); ?></p>
        <br>
        <h4>Messages</h4>
        <div>
            <?php if($article->getMessages() != null): ?>
            <?php foreach ($article->getMessages() as $message): ?>
                <div class="message">
                    <?php $b = new DateTime($message->getCreationDate()) ?>
                    <p class="text-right"><?= $b->format('d/m/Y H:i:s')?></p>
                    <p><b>Utilisateur:</b> <?=$message->getAuthor()->getLastname()?></p>
                    <div>
                        <p><?=$message->getMessage()?></p>
                        <p class="text-right">
                            <?php if($user->getStatus() == 'Admin'): ?>
                                <a href="#" title="Bannir l'utilisateur" data-modal-target="modal3" data-id="<?= $message->getId() ?>" class="cursor btnResolve" ><i class="fas fa-ban"></i></a>
                            <?php endif; ?>
                            <?php if($message->getAuthor()->getId() == $user->getId()): ?>
                                <a title="Modification" href="<?php echo Helpers::getUrl("Forum", "updatemessagearticleview") ?>?id=<?= $message->getId() ?>"><i class="fas fa-edit"></i></a>
                            <?php endif; ?>
                            <?php if(($message->getAuthor()->getId() == $user->getId()) || $user->getStatus() == 'Admin'): ?>
                                <a title="Suppression" href="#" data-modal-target="modal1" data-id="<?= $message->getId() ?>" class="cursor btnDelete"><i class="fas fa-trash-alt"></i></a>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
                <br>
            <?php endforeach;?>
            <?php else:?>
                <p>Aucun message</p>
            <?php endif;?>
        </div>
    </div>

    <div class="row">
        <?php if(!$user->isBan()): ?>
            <span>Ajouter un nouveau message:</span>
            <form method="POST"  action="<?php echo Helpers::getUrl("Forum", "addmessagearticle") ?>">
                <input type="hidden" name="article" value="<?=$article->getId()?>">
                <textarea name="message" rows="20" cols="100">

                </textarea>
                <button class="btn btn--primary" type="submit">Envoyer</button>
            </form>
        <?php else: ?>
            <span>Vous avez été banni pour des messages précédent, pour pouvoir envoyer de nouveau message vous devez contacter l'admin</span>
        <?php endif; ?>

    </div>

    <div class="modal" id="modal1"> <!-- This is the background overlay -->
        <div class="modal-content"> <!-- This is the actual modal/popup box -->
            <span class="modal-close">&times;</span>
            <p>Souhaitez-vous vraiment supprimer ce message?</p>
            <form method="POST"  action="<?php echo Helpers::getUrl("Forum", "removemessagearticle") ?>">
                <input type="hidden" id="idToDelete" name="id">
                <button type="submit" id="yesBtnD" class="btn btn--success">Oui</button>
                <button type="button" class="btn btn--danger btnNo">Non</button>
            </form>
        </div>
    </div>


    <div class="modal" id="modal3"> <!-- This is the background overlay -->
        <div class="modal-content"> <!-- This is the actual modal/popup box -->
            <span class="modal-close">&times;</span>
            <p>Souhaitez-vous vraiment bannir l'utilisateur pour ce message ?</p>
            <form method="POST"  action="<?php echo Helpers::getUrl("Forum", "banuser") ?>">
                <input type="hidden" id="idToResolve" name="id">
                <button type="submit" id="yesBtnR" class="btn btn--success">Oui</button>
                <button type="button" class="btn btn--danger btnNo">Non</button>
            </form>
        </div>
    </div>
</div>