<?php 
$annonces = false;
if(!empty($_GET['id'])){
    $a = new Annonces();
    $annonces = $a->getById($_GET['id']);
}  

if(!$annonces) die('Une erreur est survenue');

?>

<div class="categories">
            <h1>Modifier une annonce</h1>
            <?= getFormErrors(); ?>
            <form enctype="multipart/form-data" method='post' action=''>
            <input type="hidden" name="c" value="Annonces"><br> 
           <input type="hidden" name="m" value="update">
           <input type='hidden' name='id' value='<?= $annonces['id_annonce'] ?? '' ?>'>
        <div class='form-group my-3'>
        <label for='text'>Titre</label>
            <input type='text' name='titre' class='form-control' id='titre' placeholder='Enter le titre' required autofocus value='<?= !empty($annonces['titre']) ? htmlentities($annonces['titre']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
        <label for='text'>Description</label>
            <input type='text' name='description' class='form-control' id='description' placeholder='Enter la description' required autofocus value='<?= !empty($annonces['description']) ? htmlentities($annonces['description']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
        <label for='text'>Durée de publication de l'annonce</label>
            <input type='text' name='duree_de_publication_en_mois' class='form-control' id='duree' placeholder='Entrer la durée' required autofocus value='<?= !empty($annonces['duree_de_publication_en_mois']) ? htmlentities($annonces['duree_de_publication_en_mois']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='number'>Prix de vente</label>
            <input type='number' step="any" name='prix_vente_objet' class='form-control' id='prix_vente' placeholder='Enter le prix de vente' required autofocus value='<?= !empty($annonces['prix_vente_objet']) ? htmlentities($annonces['prix_vente_objet']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
        <label for='text'>id Etat</label>
            <input type='number' name='id_etat' class='form-control' id='id_etat' placeholder='Enter id etat'' required autofocus value='<?= !empty($annonces['id_etat']) ? htmlentities($annonces['id_etat']) : '' ?>'>
        </div>

        <!-- <label for="file">Ajouter des images</label>
        <input type="file" id="image" name="photo[]" placeholder="photo" multiple accept="image/*"><br><br> -->

        <button type='submit' class='btn btn-primary my-3' name='submit'>Modifier</button>
    </form>
</div>