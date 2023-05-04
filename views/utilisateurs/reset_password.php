<?php
if(!empty($_GET['t'])){
?>
<h1>Réinitialisation mot de passe</h1>
<?= getFormErrors(); ?>
<div class="signup">
		<form method="POST" action="">
			<label for="chk">Réinitialisation</label>
            <input type="hidden" name="c" value="user">
            <input type="hidden" name="m" value="resetPwd ">
			<input type="hidden" name="token" value="<?= $_GET['t']; ?>">
			<input type="password" name="password" placeholder="Mot de passe" required title="Le mot de passe doit comporter au moins 8 caractères dont au moins 1 chiffre, 1 minuscule, 1 majuscule et 1 caractères spécial">
			<input type="password" name="password_verify" placeholder="Confirmation du mot de passe" required>
			<button type="submit">Réinitialiser</button>
		</form>
	</div>
<? } else die("page protégée"); ?>