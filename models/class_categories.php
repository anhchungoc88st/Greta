<?php

class Categories extends Db {

    public function __construct()
    {
        parent::__construct(); // lance la connexion à la bdd grâce au constructeur de la classe mère
        $this->table = 'categories'; //on change la propriété "table" en y mettant le nom de la table dont on aura besoin ici et dans les méthodes de la classe mère
    }

    public function delete($id){
       return $this->delete_($id);
    }

    public function getById($id){
        return $this->getById_($id);
    }

    public function getAll($limit=10,$page=1){
        return $this->getAll_($limit,$page);
    }

    public function update($id){
        try {
          $db = $this->db;
          $updateUser = $db->prepare('UPDATE '.$this->table.' SET nom_categorie = :categorie WHERE id = :id');
          return $updateUser->execute([
            'categorie' => $_POST['nom_cat'],           
            'id' => $id
          ]);
        } catch (Exception $e) {
            if(DEBUG_MODE) echo $e->getMessage();
        }
        return false;
    }

      //ajout d'un nouvel catégorie
      public function add(){
        try {
            $db = $this->db;
            $addCat = $db->prepare('INSERT INTO '.$this->table.' (nom_categorie) VALUES (:categorie) ');
            $req = $addCat->execute([
                'nom_categorie' => $_POST['nom_cat']
            ]);
            if($req) return $db->lastInsertId();
        } catch (Exception $e) {
            if(DEBUG_MODE) echo $e->getMessage();
        }
        return false;
    }
 
    public function getByName($nom){
        try {
            $db = $this->db;
            $catQuery = $db->prepare('SELECT * FROM '.$this->table.' WHERE nom_categorie = :nom');
           // echo 'SELECT * FROM '.$this->table.' WHERE nom = '.$nom;
            $catQuery->execute(['nom' => $nom]);
            return $catQuery->fetch();
        } catch(Exception $e){
            if(DEBUG_MODE) echo $e->getMessage();
        }
        return false;
    }

    
}

?>

