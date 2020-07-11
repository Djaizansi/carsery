<?php

namespace carsery\core;

use carsery\core\Connection\BDDInterface;
use carsery\core\Connection\PDOConnection;
use carsery\core\Exceptions\BDDException;

class DB
{
    private $table;
    private $connection;
    protected $class;

    public function __construct(string $class, string $table, BDDInterface $connection = NULL)
    {
        $this->class = $class;
        $this->table = DB_PREFIXE . $table;

        $this->connection = $connection;
        if (is_null($connection)) {
            $this->connection = new PDOConnection();
        }
        /* $table = DB_PREFIXE.get_called_class();
        $this->table = DB_PREFIXE.substr($table,strrpos($table,'\\')+1,strlen($table)); //.get_called_class() => la classe appelé quand on se dirige vers register est USER
        var_dump($this->table); */
    }

    public function save($objectToSave)
    {
        $objectArray = $objectToSave->__toArray();
        $columnsData = array_values($objectArray);
        $columns = array_keys($objectArray);

        $params = array_combine(array_map(function ($k) {
            return ':' . $k;
        }, array_keys($objectArray)), $objectArray);

        if (!is_numeric($objectToSave->getId())) {
            $sql = "INSERT INTO " . $this->table . "(" . implode(",", $columns) . ") VALUES (:" . implode(",:", $columns) . ");";
        } else {
            //"UPDATE users SET id=:id, firstname=:firstname, .... WHERE id = :id;"
            foreach ($columns as $column) {
                $sqlUpdate[] = $column . "=:" . $column;
            }

            $sql = "UPDATE " . $this->table . " SET " . implode(",", $sqlUpdate) . " WHERE id=:id;";
        }
        $this->connection->query($sql, $params);
    }


    public function findAll(): array
    {
        $sql = "SELECT * FROM $this->table";
        $result = $this->connection->query($sql);
        $rows = $result->getArrayResult();
        $find = [];
        foreach ($rows as $row) {
            $object = new $this->class();
            try {
                array_push($find, $object->hydrate($row));
            } catch (BDDException $e) {
                die($e->getMessage());
            }
        }

        return $find;
    }

    public function findBy(array $params, array $order = null): array
    {
        $results = array();
        $sql = "SELECT * FROM $this->table WHERE ";
        foreach ($params as $key => $value) {
            if (is_string($value)) {
                $comparator = 'LIKE';
            } else {
                $comparator = '=';
            }
            $sql .= "$key $comparator :$key AND ";

            $params[":$key"] = $value;
            unset($params[$key]);
        }
        $sql = rtrim($sql, 'AND ');

        if ($order) {
            $sql .= "ORDER BY '" . key($order) . " " . $order[key($order)];
        }

        $result = $this->connection->query($sql, $params);
        $rows = $result->getArrayResult();

        foreach ($rows as $row) {
            $object = new $this->class();
            try {
                array_push($results, $object->hydrate($row));
            } catch (BDDException $e) {
                die($e->getMessage());
            }
        }

        return $results;
    }

    public function count(array $params): int
    {
        $results = array();

        $sql = "SELECT COUNT(*) FROM $this->table WHERE";

        foreach ($params as $key => $value) {
            if (is_string($value)) {
                $comparator = 'LIKE';
            } else {
                $comparator = '=';
            }
            $sql .= "$key $comparator :$key AND";

            $params[":$key"] = $value;
            unset($params[$key]);
        }
        $sql = rtrim($sql, 'AND');

        $result = $this->connection->query($sql, $params);
        return $result->getValueResult();
    }

    public function find(int $id): ?\carsery\models\Model
    {
        $sql = "SELECT * FROM $this->table WHERE id =:id";
        $results = $this->connection->query($sql, [':id' => $id]);
        $row = $results->getOneOrNullResult();

        if ($row) {
            $object = new $this->class;
            try {
                return $object->hydrate($row);
            } catch (BDDException $e) {
                die($e->getMessage());
            }
        } else {
            return null;
        }
    }




    public function delete($attribut, $value)
    {
        $sql = "DELETE FROM $this->table WHERE $attribut = :$attribut";
        $result = $this->connection->query($sql, [":$attribut" => $value]);
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

    /**
     * Get the value of connection
     */
    public function getConnection()
    {
        return $this->connection;
    }
}
