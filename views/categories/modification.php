<?php 

$Categorie = false;

if(!empty($_GET["id"])){
    $Cat=new Categories();
    $Categorie=$Cat->getById($_GET["id"]);
}

if(!$Categorie) die("erreur");


?>
<div class='row'>
    <form method='post' action=''>
  
        <div class='form-group my-3'>
            <input type='hidden' name='id' value='<?= $Categorie['id_categorie'] ?? '' ?>'>
            <label for='text'>Nom catégorie</label>
            <input type='text' name='nom_cat' class='form-control' id='nom_cat' placeholder='Enter nom de la catégorie' required autofocus value='<?= isset($Categorie['nom_categorie']) ? htmlentities($Categorie['nom_categorie']) : '' ?>'>
        </div>
       <button type='submit' class='btn btn-primary my-3' name='submit'>Modifier la catégorie</button>
    </form>
</div>