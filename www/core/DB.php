<?php

namespace Carsery\Core;

use \PDO;

use Carsery\Exceptions\BDDExceptions;

class DB
{
    private $table;
    private $pdo;
    protected $class;

    public function __construct(string $class, string $table)
    {
        //SINGLETON
        $this->class = $class;
        try {

            $this->pdo = new PDO(DB_DRIVER.":host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PWD);
		
        } 
		catch (Exception $e) {
            die("Erreur SQL : ".$e->getMessage());
        }

        $this->table =  DB_PREFIXE.$table;
	
    }

	/**
	 * Génère dynamiquement les requetes d'insertion et de modification en fonction d'un model donné
	 */
    public function save($objectToSave)
    {
		
		$objectArray = $objectToSave->__toArray();
        $columnsData = array_values($objectArray);
        $columns = array_keys($objectArray);

        $params = array_combine(array_map(function($k){ return ':'.$k; }, array_keys($objectArray)),$objectArray);

        
          if (!is_numeric($objectToSave->getId())) {
			            
            //INSERT
            $sql = "INSERT INTO ".$this->table." (".implode(",", $columns).") VALUES (:".implode(",:", $columns).");";
			echo($sql);
			
        } 
		
		
		else {

            //UPDATE
            foreach ($columns as $column) {
                $sqlUpdate[] = $column."=:".$column;
				
            }

            $sql = "UPDATE ".$this->table." SET ".implode(",", $sqlUpdate)." WHERE id=:id;";
			echo($sql);
        }

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($columnsData);
    }
    
    /**
     * Supprime un tuple en fonction de son id et d'un model donné
     */
	public function remove() : bool{

        try{
    
        
            if(!$this->id){
    			
                    throw new Exception('Aucun identifiant n\' est mentionné , la suppression ne peut pas etre effectuer');
                }

            else{

                $sql = "DELETE FROM ".$this->table." WHERE id= :id;";
                $result = $this->pdo->prepare($sql);
                $result->execute([':id' => $id]);

            }
        }

        catch(Exception $e){

            echo $e->getMessage();
        }
    }
	
	/**
     * Retourne le résultat d'une requete SELECT sous de tableau d'objets
     * @param type $sql
     * @param Object $object
     * @param Object $params
     * @param $class_name
     * @return array
     */
    function findBy($sql,Object $object,$params = null,$class_name) : array{

        if(empty($params)){

         $statement = $this->pdo->query($sql) or die(print_r($this->pdo->errorInfo()));
         $statement->execute();

	try{
         	$this->hydrate($object);
	}

	catch(BDDException $e){

		echo $e->getMessage();
	}

         $results = $statement->fetchAll(PDO::FETCH_CLASS, $class_name);


         return $results;

        }

        else{

            $statement = $this->pdo->prepare($sql) or die(print_r($this->pdo->errorInfo()));
            $statement->execute($params);

            try{
         	$this->hydrate($object);
	    }

	    catch(BDDException $e){

		echo $e->getMessage();
	    }

            $results = $statement->fetchAll(PDO::FETCH_CLASS, $class_name);

    
            return $results ;

        }

    }

     public function findAll(){

        $stmt = $this->pdo->query("SELECT * FROM ".$this->table) 
        or die(print_r($this->pdo->errorInfo()));
        
        $objects = [];

        while ($currentObject = $stmt->fetchObject(__CLASS__)) {
            
            $objects[] = $currentObject;
        }
        
        return $objects;

    }

     public function find(int $id){

        $result = $this->pdo->prepare("SELECT * FROM ".$this->table." WHERE id = :id");

        //$result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute([':id' => $id]);

        return $result->fetchObject(__CLASS__);
    }
    
}

