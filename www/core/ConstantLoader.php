<?php

namespace Carsery\Core;

class ConstantLoader
{
    public $extend;
    public $text;
    
    public function __construct($extend = "prod")
    {
        $this->extend = $extend;
        $this->checkFilesEnv();
        $this->getContentFiles();
        $this->load();
    }

    public function checkFilesEnv()
    {
        if (!file_exists(".env")) {
            die("Le fichier .env n'existe pas");
        }
        if (!file_exists(".".$this->extend)) {
            die("Le fichier .".$this->extend." n'existe pas");
        }
    }

    public function getContentFiles()
    {
        $this->text = file_get_contents(".env");

        $this->text .= "\n".file_get_contents(".".$this->extend);
    }
    
    public function load()
    {
        $lines = explode("\n", $this->text);
        foreach ($lines as $line) {
            $data = explode("=", $line);
            if (!defined($data[0]) && isset($data[1])) { //Defined la meme chose que isset sauf que cela ne s'applique qu'aux constante 
                define($data[0], $data[1]);
            }
        }
    }
}
