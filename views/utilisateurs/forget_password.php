<h1>Mot de passe oublié</h1>
<div class="signup">
	<form method="POST" action="">
		<?= getFormErrors(); ?>
        <input type="hidden" name="c" value="user">
        <input type="hidden" name="m" value="fogetPwd">
		<input type="email" name="email" placeholder="Email" required>
		<button>Renvoyer</button>
		<a href="<?= URL_SITE; ?>?p=login">La mémoire m'est revenue</a>
	</form>
</div>