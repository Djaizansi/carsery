<?php

namespace carsery\controllers;

use carsery\core\Exceptions\RouteException;
use carsery\core\Helpers;
use carsery\core\Mail;
use carsery\core\Session;
use carsery\core\View;

class MailController
{
    public function mailAction()
    {
        if (Session::estConnecte()) {
            $myView = new View("mail");
            //$mbox = imap_open("{imap-mail.outlook.com:993/ssl/novalidate-cert}", "service.carsery@outlook.com", "projetannuel2020", OP_HALFOPEN)
            $mbox = imap_open("{imap-mail.outlook.com:993/ssl/novalidate-cert}", "service.carsery@outlook.com", "marwaneyoucef9392", OP_READONLY)
            or die("can't connect: " . imap_last_error());

            $MC = imap_check($mbox);

            // Récupère le sommaire pour tous les messages contenus dans INBOX
            $result = imap_fetch_overview($mbox, "1:{$MC->Nmsgs}", 0);
            $newRes = [];
            foreach ($result as $overview) {
                $overview->msg = imap_fetchbody($mbox,$overview->msgno,2);
                $overview->header = imap_header($mbox,$overview->msgno,2);
                $newRes[] = $overview;
            }

            $myView->assign('messages', $newRes);

            imap_close($mbox);
        } else {
            throw new RouteException("Vous devez être connecté");
        }
    }

    public function answercontactemailAction(){
        if (Session::estConnecte()) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $message = $_POST['message'];
                $replyTo = $_POST['replyTo'];
                $subject = $_POST['subject'];

                $mail = new Mail();

                if (!isset($message)) {
                    $errors = ["Veuillez renseigner un message ayant plus de 2 lettres"];
                } else {
                    $mail->sendmail($subject, $message, $replyTo);
                }
            }
            $actionMessage = "La réponse a été envoyé avec succès";
            $location = Helpers::getUrl('Mail','mail'). "?success=1&m=$actionMessage";
            header("Location: $location");
        } else {
            throw new RouteException("Vous devez être connecté");
        }
    }
}