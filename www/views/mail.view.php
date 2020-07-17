<?php use carsery\core\Helpers; ?>


<div class="container">
    <div id="all_message">
        <h3>Tous les messages contacts</h3>

        <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
            <div class="success text-center">
                <p><?=$_GET['m']?></p>
                <br>
            </div>
        <?php endif; ?>

        <div>
            <?php if ($messages != null): ?>
                <div class="messageOverview">
                    <?php foreach ($messages as $message): ?>
                        <a class="cursor openMessageMailbox" href="#" data-id="<?= $message->msgno ?>">
                            <div id="messageOverview-<?= $message->msgno ?>" class="message removeColor">
                                <?php $d = new DateTime($message->date); ?>
                                <b>De:</b> <?= $message->from ?> |
                                <b>Sujet:</b> <?= $message->subject ?> |
                                <b>le </b> <?= $d->format('d/m/Y H:i:s') ?>
                            </div>
                        </a>
                        <br>
                    <?php endforeach; ?>
                </div>

                <div class="readMessage">
                    <?php foreach ($messages as $message): ?>
                        <div>
                            <div id="message-<?= $message->msgno ?>" class="hide messageToHide">
                                <div class="mail"><?= $message->msg ?></div>
                                <form method="POST" action="<?php echo Helpers::getUrl("Mail", "answercontactemail") ?>">
                                    <input type="hidden" name="subject" value="<?= $message->subject ?>">
                                    <input type="hidden" name="replyTo" value="<?= $message->header->from[0]->mailbox . "@" . $message->header->from[0]->host ?>">
                                    <textarea name="message" class="hidden" placeholder="Répondre" cols="90" rows="15">
                                    </textarea>
                                    <br>
                                    <button type="submit" class="btn btn--primary">Répondre</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>