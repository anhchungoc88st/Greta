<?php

class Db {

    //propriétés privées

    private $hostname = "localhost";
    private $dbname = "ident";
    private $username = "root";
    private $password = "";
    protected $db;
    protected $table='';

    function __construct(){
        try{
            $dbh = new PDO("mysql:host=$this->hostname;dbname=$this->dbname", $this->username, $this->password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->db = $dbh;
        } catch (Exception $e){
            if(DEBUG_MODE) echo $e->getMessage();
        }
    }

    /* getter pour l'instance PDO enregistrée dans un objet dans la propriété "db" */
    public function getDb(){
        return $this->db;
    }

    protected function delete_($id){ //méthode publique
        $db = $this->db;
        $deleteQuery = $db->prepare("DELETE FROM ".$this->table." WHERE id = :id");
        return $deleteQuery->execute(["id" => $id]);
    }

    protected function getById_($id){
        try {
            $db = $this->db;
            $userQuery = $db->prepare('SELECT * FROM '.$this->table.' WHERE id = :id');
            $userQuery->execute(['id' => $id]);
            return $userQuery->fetch();
        } catch(Exception $e){
            if(DEBUG_MODE) echo $e->getMessage();
        }
        return false;
    }
      
    protected function getAll_($limit=10,$page=1){
        try {
          $db = $this->db;
          $users=$db->query('SELECT * FROM '.$this->table.' '.generate_sql_limit($limit,$page));
          return $users->fetchAll();
        } catch (Exception $e) {
          if(DEBUG_MODE) echo $e->getMessage();
        }
        return false;
    }

}


?>