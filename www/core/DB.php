<?php

namespace carsery\core;

use PDO;
use Exception;

class DB
{
    private $table;
    private $pdo;
    protected $class;

    public function __construct(string $class, string $table)
    {
        $this->class = $class;
        //SINGLETON
        try {
            $this->pdo = new PDO(DB_DRIVER.":host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PWD);
        } catch (Exception $e) {
            die("Erreur SQL : ".$e->getMessage());
        }
        $this->table = DB_PREFIXE.$table;
        /* $table = DB_PREFIXE.get_called_class();
        $this->table = DB_PREFIXE.substr($table,strrpos($table,'\\')+1,strlen($table)); //.get_called_class() => la classe appelé quand on se dirige vers register est USER
        var_dump($this->table); */
    }

    protected function sql($sql, $parameters = null)
    {
        if ($parameters) {
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($parameters);
        return $queryPrepared;

        } else {
        $queryPrepared = $this->pdo->query($sql);
        return $queryPrepared;
        }
    }

    public function save($objectToSave)
    {
        $objectArray = $objectToSave->__toArray();
        $columnsData = array_values($objectArray);
        $columns = array_keys($objectArray);

        $params = array_combine(array_map(function($k){ return ':'.$k; }, array_keys($objectArray)),$objectArray);

        if (!is_numeric($objectToSave->getId())) {
            $sql = "INSERT INTO ".$this->table. "(".implode(",", $columns).") VALUES (:".implode(",:", $columns).");";
        } else {
            //"UPDATE users SET id=:id, firstname=:firstname, .... WHERE id = :id;"
            foreach ($columns as $column) {
                $sqlUpdate[] = $column."=:".$column;
            }

            $sql = "UPDATE ".$this->table." SET ".implode(",", $sqlUpdate)." WHERE id=:id;";
        }
        
        $this->sql($sql, $params);
    }

    
    public function findAll() : array 
    {
        $sql = "SELECT * FROM $this->table";
        $result = $this->sql($sql);
        $rows = $result->fetchAll();
        $find = [];
        foreach($rows as $row){
            $object = new $this->class();
            array_push($find, $object->hydrate($row));
        }
        
        return $find;
    }

    public function findBy(array $params, array $order = null): array{
        $results = array();
        $sql = "SELECT * FROM $this->table WHERE ";
        foreach($params as $key => $value){
            if(is_string($value)){
                $comparator = 'LIKE';
            }else{
                $comparator = '=';
            }
            $sql .= "$key $comparator :$key AND ";

            $params[":$key"] = $value;
            unset($params[$key]);
        }
        $sql = rtrim($sql,'AND ');

        if($order){
            $sql .= "ORDER BY '". key($order). " ". $order[key($order)];
        }

        $result = $this->sql($sql, $params);
        $rows = $result->fetchAll();

        foreach($rows as $row){
            $object = new $this->class();
            array_push($results, $object->hydrate($row));
        }

        return $results;
    }

    public function count(array $params): int
    {
        $results = array();

        $sql = "SELECT COUNT(*) FROM $this->table WHERE";

        foreach($params as $key => $value){
            if(is_string($value)){
                $comparator = 'LIKE';
            }else{
                $comparator = '=';
            }
            $sql .= "$key $comparator :$key AND";

            $params[":$key"] = $value;
            unset($params[$key]);
        }
        $sql = rtrim($sql, 'AND');

        $result = $this->sql($sql, $params);
        return $result->fetchColumn();

        
    }

    public function find(int $id): ?\carsery\models\Model
    {
        $sql = "SELECT * FROM $this->table WHERE id =:id";
        $results = $this->sql($sql,[':id' => $id]);
        $row = $results->fetch();

        if ($row) {
            $object = new $this->class;
            return $object->hydrate($row);
        }else {
            return null;
        }

    }

    /* public function find(string $recherche ,string $attribut = NULL, $value = NULL){
        $attribut_exist = isset($attribut) ? " WHERE $attribut = :$attribut" : '';
        $donnee_exist = isset($attribut) ? [":$attribut" => $value] : '';
        $sql = "SELECT $recherche FROM $this->table".$attribut_exist;
        $result = $this->sql($sql,$donnee_exist);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $row = $result->fetch();
        $class = get_called_class();

        if(isset($attribut) && $result->rowCount() < 2){
            if ($row) {
                $object = new $class();
                return $object->hydrate($row);
            } else {
                return null;
            }
        }else {
            $users = [];
            isset($users) ? $users : NULL;
            while($row){
                $object = new $class();
                $users[] = $object->hydrate($row);
                $row = $result->fetch();
            }
            $result->closeCursor();
            return $users;
        }
    } */

    public function getByAttribut($elementAttribute, $valueAttribute, $value) {
        $sql = "SELECT $elementAttribute FROM $this->table WHERE $valueAttribute = :$valueAttribute";
        $result = $this->sql($sql, [":$valueAttribute" => $value]);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        return $row;
    }

    public function getByAttrubutMultiple($elementAttribute, $valueAttribute, $value, $addparameterAttribute, $addvalue){
        $sql = "SELECT $elementAttribute FROM $this->table WHERE $valueAttribute = :$valueAttribute AND $addparameterAttribute = :$addparameterAttribute";
        $result = $this->sql($sql, [":$valueAttribute" => $value, ":$addparameterAttribute" => $addvalue]);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        
        $class = get_called_class();
        if ($row) {
            $object = new $class();
            return $object->hydrate($row);
        } else {
            return null;
        }
    }
    

    public function delete($attribut, $value){
        $sql = "DELETE FROM $this->table WHERE $attribut = :$attribut";
        $result = $this->sql($sql, [":$attribut" => $value]);
    }

    /**
     * Get the value of table
     */ 
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Get the value of class
     */ 
    public function getClass()
    {
        return $this->class;
    }
}