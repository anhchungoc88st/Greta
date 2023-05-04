<?php 

/*
require_once(DIR_PATH.'controllers/class_validate.php'); 
if(!empty($_POST)){

    $_POST['prix_vente_objet'] = floatval($_POST['prix_vente_objet']);

    $v = new Validate($_POST);

    $v->validate([
        'titre' => ['required','maxLength:150','type:string'],
        'description' => ['minLength:50','maxLength:500','type:string'],
        'duree_de_publication_en_mois' => ['required','type:numeric'],
        'prix_vente_objet' => ['required','type:float'],
        'id_paiement'=> ['required','type:numeric'],
        'id_etat'=> ['required','type:numeric']
    ]);

    if(!$v->ok()) { //méthode qui vérifie s'il n'y a pas d'erreurs
        print_r($v->errors()); //on affiche les erreurs
    }

    $_POST = $v->getDatas();
}
*/

?>

<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Ajouter une Annonce</h1>
    <?= getFormErrors(); ?>
</div>
<div class='row'>
    <form enctype="multipart/form-data" method='post' action=''>
   
        <div class='form-group my-3'>
        <label for='text'>Titre</label>
            <input type='text' name='titre' class='form-control' id='titre' placeholder='Enter le titre' autofocus value='<?= isset($annonces['titre']) ? htmlentities($annonces['titre']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
        <label for='text'>Description</label>
            <input type='text' name='description' class='form-control' id='description' placeholder='Enter la description' autofocus value='<?= isset($annonces['description']) ? htmlentities($annonces['description']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
        <label for='text'>Durée de publication de l'annonce</label>
            <input type='text' name='duree_de_publication_en_mois' class='form-control' id='duree' placeholder='Entrer la durée' autofocus value='<?= isset($annonces['duree_de_publication_en_mois']) ? htmlentities($annonces['duree']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
        <label for='number'>Prix de vente</label>
            <input type='number' step="any" name='prix_vente_objet' class='form-control' id='prix_vente' placeholder='Enter le prix de vente' autofocus value='<?= isset($annonces['prix_vente']) ? htmlentities($annonces['prix_vente']) : '' ?>'>
        </div>
    <div class='form-group my-3'>
        <label for='text'>id mode de paiement</label>
            <input type='number' name='id_paiement' class='form-control' id='id_paiement' placeholder='Enter le mode de paiement' autofocus value='<?= isset($annonces['id_paiement']) ? htmlentities($annonces['id_paiement']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
        <label for='text'>id Etat</label>
            <input type='number' name='id_etat' class='form-control' id='id_etat' placeholder='Enter id etat' autofocus value='<?= isset($annonces['id_etat']) ? htmlentities($annonces['id_etat']) : '' ?>'>
        </div>

        <label for="file">Ajouter des images</label>
        <input type="file" id="image" name="photo[]" placeholder="photo" multiple accept="image/*"><br><br>

        <input type="hidden" name="c" value="annonces">
        <input type="hidden" name="m" value="add">

        <button type='submit' class='btn btn-primary my-3' name='submit'>Ajouter une annonce</button>
    </form>
</div>