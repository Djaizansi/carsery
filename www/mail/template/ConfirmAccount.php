<?php

namespace carsery\mail\template;

use carsery\core\Helpers;
use carsery\Managers\UserManager;

class ConfirmAccount
{
    public static function mailConfirm($pseudo, $email)
    {
        $userManager = new UserManager();
        $found = $userManager->findByEmail($email);
        var_dump($_POST);
        $id = $found->getId();
        $accueil = Helpers::getUrl('myProject', 'view');
        $confirmation = Helpers::getUrl('User', 'confirmAccount');
        $token = $found->getToken();
        return '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>Confirmation de compte - Carsery</title>
                </head>
                <body>
                    <font color="#303030";>
                     <div align="center">
                        <table width="600px">
                            <tr>
                                <td>
                                    <div align="center">
                                        Bonjour <b>' . $pseudo . '</b>,<br>
                                        Voici votre lien d\'activation de compte: <a href="http://localhost/confirmAccount?id=' . $id . '&token=' . $token . '">Activer mon compte</a> <br>
                                        A bientôt sur <a href="http://localhost">Votre site</a> !
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <font size="2">
                                         Ceci est un email automatique, merci de ne pas y répondre
                                    </font>
                                </td>
                            </tr>
                        </table>
                    </div>
                    </font>
                </body>
        </html>';
    }
}
