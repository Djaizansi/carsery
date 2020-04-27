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
        var_dump($queryPrepared);
    }

    protected function sql($sql, $parameters = null)
    {
        if ($parameters) {
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($parameters);

        return $queryPrepared;
        } else {
        $queryPrepared = $this->pdo->prepare($sql);

        return $queryPrepared;
        }
    }

    public function login($email,$pwd){
        $sql = "SELECT * FROM " .$this->table. " WHERE email='" .$email. "' AND pwd ='" .$pwd. "';";
        $queryPrepared = $this->pdo->query($sql);
        $queryPrepared->setFetchMode(PDO::FETCH_OBJ);
        $donnee= $queryPrepared->fetch();
        if($donnee){
            echo "CONNEXION RÉUSSI !";
        }else {
            echo "CONNEXION ÉCHOUÉE !";
        }
        $queryPrepared->closeCursor();
        return $donnee;
    }

    public function getById($id,$model,$tab){
        $sql = "SELECT * FROM " .$this->table. " WHERE id=".$id.";";
        $queryPrepared = $this->pdo->query($sql);
        $queryPrepared->setFetchMode(PDO::FETCH_OBJ);
        $donnee= $queryPrepared->fetch();
        if($donnee){
            $uneDonnee = new $model();
            foreach($tab as $untab){
                $set = "set".ucfirst($untab);
                $uneDonnee->$set($donnee->$untab);
            }
            return $uneDonnee;
            /* return $user; */
        }
        $queryPrepared->closeCursor();
        /* return NULL; */
        return NULL;
    }

    public function find(int $id){
        $sql = "SELECT * FROM $this->table where id = :id";
        $result = $this->sql($sql, [':id' => $id]);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        return $row;
        /* if ($row) {
            $object = new Users();
            return $object->hydrate($row);
        } else {
            return null;
        } */
    }

    /* public function find(int $id){
        /* $sql = "SELECT * FROM $this->table WHERE id=:id";
        $result = $this->sql[':id' => $id]);
        $row = $result->fetch(); */
        /* $sql = "SELECT * FROM $this->table WHERE id=:id";
        $preparedQuery = $this->pdo->prepare($sql);
        $preparedQuery->execute(['id' => $id]);
        $preparedQuery->setFetchMode(PDO::FETCH_ASSOC);
        $tab = [];
        $donnee = $preparedQuery->fetch();
        foreach($donnee as $key => $uneDonnee) {
            $tab[$key] = $uneDonnee;
        }
        return $tab;*/
        
        /* $row = $preparedQuery->fetch();
        if($row) {
            $object = new users();
            return $object->hydrate($row);
        } else {
            return null;
        } */

        /* $propChild = get_object_vars($this);
        $propDB = get_class_vars(get_class());
        $columnsData = array_diff_key($propChild, $propDB); */
}