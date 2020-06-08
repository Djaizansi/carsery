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
        //Permet de récuperer les données du fichier de connection
        $this->connection = $connection;
        if(is_null($connection)){
            $this->connection = new PDOConnection();
        }
    }

    public function select( string $values = '*' ): QueryBuilder
    {
        $this->query="SELECT ".$values;
        return $this;
    }

    public function from( string $table, string $alias ): QueryBuilder
    {
        $this->alias = $alias;
        $this->query.=" FROM $table " . " " .$this->alias;
        return $this;
    }

    public function where( string $condition ): QueryBuilder
    {
        $this->query.=" WHERE $condition";
        return $this;
    }

    public function setParameter( string $key, string $value): QueryBuilder
    {
        $this->parameters[$key] = $value;
        return $this;
    }

    public function join( string $table, string $aliasTarget, string $fieldSource = 'id', string $fieldTarget = 'id' ): QueryBuilder
    {
        $this->query.= " INNER JOIN $table $aliasTarget ON ". $this->alias.".".$fieldSource." = " .$aliasTarget.".".$fieldTarget;
        return $this;
    }

    public function leftjoin( string $table, string $aliasTarget, string $fieldSource = 'id', string $fieldTarget = 'id' ): QueryBuilder
    {
        $this->query.= "LEFT JOIN $table $aliasTarget ON ". $this->alias.".".$fieldSource." = " .$aliasTarget.".".$fieldTarget;
        return $this;
    }

    public function addToQuery( string $query ): QueryBuilder
    {
        $this->query .= " ".$query;
        return $this; 
    }

    public function getQuery(): ResultInterface
    {
        return $this->connection->query($this->query,$this->parameters);
    }

}