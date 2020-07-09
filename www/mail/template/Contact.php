<?php

namespace carsery\mail\template;

class Contact
{
    public static function contact($message){

        return '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>Réponse contact - Carsery</title>
                </head>
                <body>
                    <font color="#303030";>
                     <div align="center">
                        <table width="600px">
                            <tr>
                                <td>

                                    <div align="center">
                                        <p>'. $message .'</p>
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