<?php
namespace carsery\core;
use carsery\core\Connection\BDDInterface;
use carsery\core\Connection\PDOConnection;
use carsery\core\Connection\ResultInterface;

class QueryBuilder {

    protected $connection;
    protected $fields;

public function __construct(BDDInterface $connection = NULL) {
    $this->connection = $connection;
}

public function select( string $value = '*'): QueryBuilder{
    $this->fields = $fields;
    return $this;


}


public function from ( string $table, string $alias): QueryBuilder {
    $this->from .= $table . " " . $alias . ",";
    return $this;


}


public function where (string $conditions): QueryBuilder {

    $this->where .= $where;
    return $this;


}



public function setParameter( string $key, string $value): QueryBuilder {
    $this->parameters[$key] = $value;
    return $this;

}


public function join( string $table, string $aliasTarget, string $fieldsource ='id', string $fieldTarget ='id'): QueryBuilder {
    array_push($this->join, " JOIN " . $table . " " . $aliasTarget . " ON " . $fieldSource . " = " . $fieldTarget);
    return $this;


}

public function leftjoin( string $table, string $aliasTarget, string $fieldsource ='id', string $fieldTarget ='id'): QueryBuilder {
    array_push($this->join, " LEFT JOIN " . $table . " " . $aliasTarget . " ON " . $fieldSource . " = " . $fieldTarget);
    return $this;


}

public function rightJoin(string $table, string $aliasTarget, string $fieldSource = 'id', string $fieldTarget = 'id'): QueryBuilder
{
    array_push($this->join, " RIGHT JOIN " . $table . " " . $aliasTarget . " ON " . $fieldSource . " = " . $fieldTarget);
    return $this;
}

public function innerJoin(string $table, string $aliasTarget, string $fieldSource = 'id', string $fieldTarget = 'id'): QueryBuilder
{
    array_push($this->join, " INNER JOIN " . $table . " " . $aliasTarget . " ON " . $fieldSource . " = " . $fieldTarget);
    return $this;
}



public function addToQuery(string $query):  QueryBuilder {

}

public function getQuery(): ResultInterface {
    return $this->connection->query($this->toSQL(), $this->parameters);
}

}