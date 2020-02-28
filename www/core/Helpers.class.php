<?php

class Helpers
{
    public static function getUrl($controller, $action)
    {
        $routes = yaml_parse_file("routes.yml"); // ou yaml_parse_file(../routes.yml);
        if (!empty($routes)) {
            /* $key = array_keys($routes); */
            foreach ($routes as $key => $values) {
                if ($values["controller"]==$controller && $values["action"]==$action) {
                    return $key;
                } else {
                }
            }
        } else {
            die("Le fichier cache n'est pas généré");
        }
    }
}
