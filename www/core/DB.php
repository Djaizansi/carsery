<?php

namespace carsery\core;

use PDO;
use Exception;

class DB
{
    private $table;
    private $pdo;

    public function __construct()
    {
        //SINGLETON
        try {
            $this->pdo = new PDO(DB_DRIVER.":host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PWD);
        } catch (Exception $e) {
            die("Erreur SQL : ".$e->getMessage());
        }
        $table = DB_PREFIXE.get_called_class();
        $this->table = DB_PREFIXE.substr($table,strrpos($table,'\\')+1,strlen($table)); //.get_called_class() => la classe appelé quand on se dirige vers register est USER
        
    }

    public function save()
    {
        $propChild = get_object_vars($this);
        $propDB = get_class_vars(get_class());
        $columnsData = array_diff_key($propChild, $propDB);
        // faire la différence entre propChild et propDB
        // si y'a des éléments de propChild qui sont pas dans propDB, on les stock dans la
        // variable columnsData
        $columns = array_keys($columnsData);

        if (!is_numeric($this->id)) {
            $sql = "INSERT INTO ".$this->table. "(".implode(",", $columns).") VALUES (:".implode(",:", $columns).");";
        } else {
            //"UPDATE users SET id=:id, firstname=:firstname, .... WHERE id = :id;"
            foreach ($columns as $column) {
                $sqlUpdate[] = $column."=:".$column;
            }

            $sql = "UPDATE ".$this->table." SET ".implode(",", $sqlUpdate)." WHERE id=:id;";
        }
        
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($columnsData);
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

    public function login($email,$pwd){
        $sql = "SELECT * FROM $this->table WHERE email = :email AND pwd = :pwd";
        $result = $this->sql($sql, [':email' => $email, ':pwd'=> $pwd]);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        if($row){
            echo "CONNEXION RÉUSSI !";
        }else {
            echo "CONNEXION ÉCHOUÉE !";
        }
        $result->closeCursor();
        return $row;

    }

    public function find(string $recherche ,string $attribut = NULL, $value = NULL){
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
    }

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
}