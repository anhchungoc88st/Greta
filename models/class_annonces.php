<?php

class Annonces extends Db {

    function __construct()
    {
        parent::__construct();//lance la connexion a la bdd
        $this->table = 'annonces';
    }

    public function delete($id){
        return $this->delete_($id);
    }

    public function getAll($limit=10,$page=1){
        return $this->getAll_($limit,$page);
    }

    public function getById($id){
        return $this->getById_($id);
    }

    public function getAllUser($limit=10,$page=1){
        try {
            $db = $this->db;
            $users=$db->prepare('SELECT * FROM '.$this->table.' WHERE id_utilisateur = :id '.generate_sql_limit($limit,$page));
            $users->execute(["id" => $_SESSION['id_user']]);
            return $users->fetchAll();
        } catch (Exception $e) {
            if(DEBUG_MODE) echo $e->getMessage();
        }
        return false;
    }

    // fonction pour mettre a jour les donnes d'un utilisateur
    public function update($id){
        try {
            $db = $this->db;
            $updateAnnonces = $db->prepare('UPDATE '.$this->table.' SET titre=:titre, description = :description, id_etat = :id_etat, prix_vente_objet=:prix_vente_objet WHERE id = :id');
            return $updateAnnonces->execute([
                'titre' => $_POST['titre'],
                'id_etat' => $_POST['id_etat'],
                'description' => $_POST['description'],
                'prix_vente_objet' => $_POST['prix_vente_objet'],
                'id' => $id
            ]);
        } catch (Exception $e) {
            if(DEBUG_MODE) echo $e->getMessage();
        }
    return false;
    }

    //ajout d'une nouvelle annonce
    public function add(){
        try {
            $db = $this->db;
            $addAnnonce = $db->prepare('INSERT INTO '.$this->table.' (date_creation, titre, description, duree_de_publication_en_mois, prix_vente_objet, cout_annonce, id_mode_paiement, id_etat, id_utilisateur) VALUES (:date_creation, :titre, :description, :duree_de_publication_en_mois, :prix_vente_objet, :cout_annonce, :id_mode_paiement, :id_etat, :id_utilisateur) ');
            $req = $addAnnonce->execute([
                'date_creation' => date("Y-m-d H:i:s"),
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'duree_de_publication_en_mois' => $_POST['duree_de_publication_en_mois'],
                'prix_vente_objet' => $_POST['prix_vente_objet'],
                'cout_annonce' => 10,
                'id_mode_paiement' => $_POST['id_paiement'],
                'id_etat' => $_POST['id_etat'],
                'id_utilisateur' => $_SESSION['id_user']
            ]);
            if($req) return $db->lastInsertId();
        } catch (Exception $e) {
            if(DEBUG_MODE) echo $e->getMessage();
        }
        return false;
    }

}


?>