<?php

    $yaml = yaml_parse_file("../routes.yml");
    
    
    $data = var_export($yaml, true); // le var_export est comme un var_dump() mais permet de retourner du code php valide

    $cache = ("../cache/routes.cache.php");

    file_put_contents($cache, "<?php return ". $data .";");
