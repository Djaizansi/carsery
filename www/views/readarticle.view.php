<?php

use carsery\core\Exceptions\RouteException;
use carsery\core\Helpers; ?>

<div class="container">
    <div class="row text-center">
        <h2 class="inline">Article</h2>
        <a class="btn btn--primary" id="myBtn" href="javascript:history.back()"><i class="fas fa-arrow-left"></i></a>
    </div>
</div>

<div class="container">

    <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
        <div class="success text-center">
            <p><?=$_GET['m']?></p>
            <br>
        </div>
    <?php endif; ?>


    <?php if(isset($article)): ?>
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
                        <p>
                            <b>Utilisateur:</b> <?=$message->getAuthor()->getLastname()?>
                            <?php if($user->getStatus() == 'Admin' && $message->getAuthor()->getStatus() != 'Admin'): ?>
                                <a href="#" title="Bannir l'utilisateur" data-modal-target="modal3" data-id="<?= $message->getId() ?>" class="cursor btnResolve" ><i class="fas fa-ban"></i></a>
                            <?php endif; ?>
                        </p>
                        <div>
                            <p><?=$message->getMessage()?></p>
                            <p class="text-right">
                                <?php if(!$user->isBan()): ?>
                                    <?php if($message->getAuthor()->getId() == $user->getId()): ?>
                                        <a title="Modification" href="<?php echo Helpers::getUrl("Forum", "updatemessagearticleview") ?>?id=<?= $message->getId() ?>"><i class="fas fa-edit"></i></a>
                                    <?php endif; ?>
                                    <?php if(($message->getAuthor()->getId() == $user->getId()) || $user->getStatus() == 'Admin'): ?>
                                        <a title="Suppression" href="#myBtn" data-modal-target="modal3" data-id="<?= $message->getId() ?>" class="myBtn"><i class="fas fa-trash-alt"></i></a>
                                    <?php endif; ?>
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
                <br><br>
                <button class="btn btn--primary" type="submit">Envoyer</button>
            </form>
        <?php else: ?>
            <span>Vous avez été banni pour des messages précédent, pour pouvoir envoyer de nouveau message vous devez contacter l'admin</span>
        <?php endif; ?>

    </div>

        <div class="modal" id="modal3"> <!-- This is the background overlay -->
            <div class="modal-content"> <!-- This is the actual modal/popup box -->
                <span class="modal-close">&times;</span>
                <p>Souhaitez-vous vraiment supprimer ce message?</p>
                <a id="btnYesSupprimer" class="btn btn--success">Oui</a>
                <a id="btnNo" class="btn btn--danger">Non</a>
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
    <?php elseif(!isset($article)): ?>
        <h3 class="text-center" style="color: #000;">Article inexistant</h3>
    <?php elseif(!isset($user)): ?>
        <p>Article inexistant</p>
    <?php endif ?>
</div>