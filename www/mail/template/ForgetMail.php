<?php

namespace carsery\mail\template;

class ForgetMail {
    public static function forgetpwd($pseudo, $recup_code){

        return '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>Récupération de mot de passe - Carsery</title>
                </head>
                <body>
                    <font color="#303030";>
                     <div align="center">
                        <table width="600px">
                            <tr>
                                <td>

                                    <div align="center">
                                        Bonjour <b>'.$pseudo.'</b>,<br>
                                        Voici votre code de récupération: <b>'.$recup_code.'</b> <br>
                                        A bientôt sur <a href="http://151.80.149.232">Votre site</a> !
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
