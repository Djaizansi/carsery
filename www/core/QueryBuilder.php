<?php

namespace carsery\core;

use carsery\core\Connection\BDDInterface;
use carsery\core\Connection\PDOConnection;
use carsery\core\Connection\ResultInterface;

class QueryBuilder
{
    protected $connection;
    protected $query;
    protected $parameters;
    protected $alias;

    public function __construct(BDDInterface $connection = NULL)
    {
        $this->connection = $connection; //Permet de récuperer les données de Connection
        if(is_null($connection)){
            $this->connection = new PDOConnection(); //Si la variable connection est null, on utilise la connection de base qui est situé dans le fichier PDOConnection
        }
    }

    public function select( string $values = '*' ): QueryBuilder
    {
        $this->query="SELECT ".$values;
        return $this; // On renvoit l'objet courant afin de pouvoir refaire appel aux autres fonctions juste après
    }

    public function from( string $table, string $alias ): QueryBuilder
    {
        $this->alias = $alias; //Recuperer la variable Alias correspondant a la table Source
        $this->query.=" FROM $table " . " " .$this->alias; //Requete From
        return $this;
    }

    public function where( string $condition ): QueryBuilder
    {
        $this->query.=" WHERE $condition"; //Toujours concatener pour ajouter les autres bouts de requete
        return $this;
    }

    public function setParameter( string $key, string $value): QueryBuilder
    {
        $this->parameters[$key] = $value; //Recupère la clé et la valeur en fonction du WHERE
        return $this;
    }

    public function join( string $table, string $aliasTarget, string $fieldSource = 'id', string $fieldTarget = 'id' ): QueryBuilder
    {
        $this->query.= " INNER JOIN $table $aliasTarget ON ". $this->alias.".".$fieldSource." = " .$aliasTarget.".".$fieldTarget; //Jointure Full Join pour récupèrer des 2 tables
        return $this;
    }

    public function leftjoin( string $table, string $aliasTarget, string $fieldSource = 'id', string $fieldTarget = 'id' ): QueryBuilder
    {
        $this->query.= "LEFT JOIN $table $aliasTarget ON ". $this->alias.".".$fieldSource." = " .$aliasTarget.".".$fieldTarget; // Left Join pour récupèrer que la partie gauche des résultats et donc renvoyer Null a certaine partie
        return $this;
    }

    public function addToQuery( string $query ): QueryBuilder
    {
        $this->query .= " ".$query; //Ajouter la Query complete 
        return $this; 
    }

    public function getQuery(): ResultInterface
    {
        return $this->connection->query($this->query,$this->parameters); //Recuperer la query et l'executer avec la fonction Query situé dans le ficheir PDOConnection
    }

}