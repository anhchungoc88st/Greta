<?php /*if(!empty($_GET['id'])){
    $a = new User();
    $user=$a->login($_GET['id']);
}  
if(!$user) die('Identifiant ou mot de passe incorrect'); */?>
<h1>Connexion</h1>
<?= getFormErrors(); ?>
<form  method="post">
  <div class="imgcontainer">
    
  </div>

  <div class="container">
  <input type="hidden" name="c" value="user"><br> 
  <input type="hidden" name="m" value="login">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="login" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
        
    <button type="submit">Login</button>

  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="<?= URL_SITE ?>?p=forget-pwd">password?</a></span>
  </div>
  <small>Envie de nous rejoindre ?</small> 

  <a href="<?= URL_SITE ?>?p=register" class="w3-bar-item w3-button">Créer un compte</a>


</form>