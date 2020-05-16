<?php

namespace Carsery\Core;

use \PDO;

class DB
{
    private $table;
    private $pdo;

    public function __construct()
    {
        //SINGLETON
        try {

            $this->pdo = new PDO(DB_DRIVER.":host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PWD);
		
        } 
		catch (Exception $e) {
            die("Erreur SQL : ".$e->getMessage());
        }

        $this->table =  DB_PREFIXE.get_called_class();
	
    }

	/**
	 * Génère dynamiquement les requetes d'insertion et de modification en fonction d'un model donné
	 */
    public function save()
    {
		
		//echo 'Table actuelle : '.$this->table."\n";
        $propChild = get_object_vars($this);
		//echo('Proprietes Objet Users')."\n";
		//print_r($propChild);
        $propDB = get_class_vars(get_class());
		//echo('Proprietes classe DB')."\n";
		print_r($propDB);

        $columnsData = array_diff_key($propChild, $propDB);
		//echo('Calcule de la différence entre les deux tables')."\n";
		//print_r($columnsData);
        $columns = array_keys($columnsData);
		//echo('Les clés de l\' objet')."\n";
		//print_r($columns);

        
        if (!is_numeric($this->id)) {
			            
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

        if(!$this->id){
			
            die('Aucun identifiant n\' est mentionné , la suppression ne peut pas etre effectuer');
            
        }

        else{

            $sql = "DELETE FROM ".$this->table." WHERE id= :id;";
            $result = $this->pdo->prepare($sql);
            $result->bindParam("id", $this->id, PDO::PARAM_INT);
            $result->execute();

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
    function retrieveData($sql,Object $object, $params = null,$class_name) : array{

        if(empty($params)){

         $statement = $this->pdo->query($sql) or die(print_r($this->pdo->errorInfo()));
         $statement->execute();

         $this->hydrate($object);

        $results = $statement->fetchAll(PDO::FETCH_CLASS, $class_name);
        //$results = $statement->fetchAll(PDO::FETCH_ASSOC);

         return $results;

        }

        else{

            $statement = $this->pdo->prepare($sql) or die(print_r($this->pdo->errorInfo()));
            $statement->execute($params);

            $this->hydrate($object);

            $results = $statement->fetchAll(PDO::FETCH_CLASS, $class_name);
            //$results = $statement->fetchAll(PDO::FETCH_ASSOC);
    
            return $results ;

        }

    }

    
}