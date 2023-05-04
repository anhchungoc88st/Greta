<?php 



/*
require_once('../../models/class_db.php');
require_once('../../models/class_users.php');

if(!isset($_SESSION)){
     session_start();
 }*/

$a = new User();
$user = $a->getById($_SESSION['id_user']);

if(!$user) die('Une erreur est survenue');

?>
<h1>Modifier profil</h1><?= getFormErrors(); ?>


<form method='POST' >
<input type="hidden" name="c" value="user"><br> 
<input type="hidden" name="m" value="update">
     <div class='form-group my-3'>
     <label for="login"> Login : </label>
     <input type="text" id="login" name="login" placeholder="Login" min="8" required autofocus value='<?= isset($user['login']) ? htmlentities($user['login']) : '' ?>'><br>

     <label for="email">Email:</label>
<input type="email" name="email" placeholder="Votre email" required  value='<?= isset($user['email']) ? htmlentities($user['email']) : '' ?>'><br>

<label for="nom">Nom:</label>
<input type="text" name="nom" placeholder="Votre nom" required  value='<?= isset($user['nom_utilisateur']) ? htmlentities($user['nom_utilisateur']) : '' ?>'><br>

<label for="prenom">Votre prénom:</label>
<input type="text" name="prenom" placeholder="Votre prénom" required value='<?= isset($user['prenom_utilisateur']) ? htmlentities($user['prenom_utilisateur']) : '' ?>'><br>

<label for="date_naissance">Date de naissance:</label>
<input type="date" name="naissance" placeholder="Date de naissance sous le format jj//mm//aaaa" required value='<?= isset($user['date_naissance']) ? htmlentities($user['date_naissance']) : '' ?>'><br>

<label for="num_telephone">Numéro de téléphone:</label>
<input type="text" name="tel" placeholder="Numéro de téléphone sous le format 06..." required  value='<?= isset($user['num_telephone']) ? htmlentities($user['num_telephone']) : '' ?>'><br>

<label for="sexe">Votre sexe:</label>
</div>
<div class="select">
 <select name="sexe">
     <option value="1" <?php if(isset($user['sexe']) && $user['sexe'] == 1) echo 'selected'; ?>>Femme</option>
     <option value="0" <?php if(isset($user['sexe']) && $user['sexe'] == 0) echo 'selected'; ?>>Homme</option>
  </select><br>
</div>

  <label for="adresse_postale">Adresse:</label>
  <div class="textarea">
     <textarea name="adresse" id="adresse_postale" rows="5" max lenght="255" cols="10" placeholder="adresse" <?= isset($user['adresse_postale']) ? htmlentities($user['adresse_postale']) : '' ?>>Adresse</textarea>
<br>
<div>
<label for="code_postal">Code postal:</label>
<input type="postal" name="postal" placeholder="Code postal" required value='<?= isset($user['code_postal']) ? htmlentities($user['code_postal']) : '' ?>'><br>
<label for="ville">Ville:</label>
<input type="ville" name="ville" placeholder="Ville" value='<?= isset($user['ville']) ? htmlentities($user['ville']) : '' ?>'><br>
     </div>
     <div class='form-group my-3'>
         
     </div>
     <button type='submit' class='btn btn-primary my-3' name='submit'>Modifier</button>
 </form>
</div>


