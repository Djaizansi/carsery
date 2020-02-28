<?php
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
        
        $this->table = DB_PREFIXE.get_called_class(); //.get_called_class() => la classe appelé quand on se dirige vers register est USER
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
}