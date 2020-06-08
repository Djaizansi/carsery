<?php

namespace carsery\core\Connection;

use Throwable;

class PDOResult implements ResultInterface
{
    protected $statement;

    public function __construct(\PDOStatement $statement)
    {
        $this->statement = $statement;
    }

    public function getOneOrNullResult()
    {
        try{
            return $this->statement->fetch();
        }catch(Throwable $t){
            echo $t->getMessage();
        }

    }

    public function getArrayResult()
    {
        return $this->statement->fetchAll();
    }

    //Fonction double pour tester le fonctionnement pour ne pas détruire au cas ou le projet entier (précaution)
    public function getArrayResultTp(string $model): array
    {
        $resultat = [];
        $results = $this->statement->fetchAll();
        if (gettype($results) != "array") //On verifie le type, si c'est different d'un tableau, on crée un tableau pour ensuite mettre ces données dedans
        {
            $results = [];
        }
        foreach ($results as $unResultat) {
            $model = new $model(); //On récupere le model
            $model->hydrate($unResultat); //On hydrate les données
            $resultat[] = $model; // On ajoute dans un tableau
        }
        return $resultat; // On retourne le tableau 
    }

    public function getValueResult()
    {
        return $this->statement->fetchColumn();
    }
}