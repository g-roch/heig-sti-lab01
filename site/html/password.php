<?php

require_once 'inc/bootstrap.php';

require 'inc/head.php';

$error = false;
$errmsg = '';

//Modification du mot de passe de l'utilisateur (si le mdp acctuel est correcte et si le nouveau et la confirmation sont identiques)
if(isset(
	$_POST['currentPassword'],
	$_POST['password'],
	$_POST['confirmPassword']
)) {
	$statement = $pdo->prepare('SELECT * FROM `users` WHERE `users`.`id` = :id');
	$statement->execute([':id' => $_SESSION['user']['userid']]);
	$user = $statement->fetch();
	if(
		is_array($user)
		&& password_verify($_POST['currentPassword'], $user['password'])
		&& ((string)$_POST['password']) === ((string)$_POST['confirmPassword'])
	) {
		$new_hash = password_hash((string)$_POST['password'], PASSWORD_DEFAULT);
		$statement = $pdo->prepare('UPDATE `users` SET `password` = :password WHERE `id` = :id');

		if($statement->execute([
			':id' => $_SESSION['user']['userid'],
			':password' => $new_hash,
		])) {
			$errmsg = "Success";
		} else {
			$error = true;
			$errmsg = "Database update failed";
		}
	} else {
		$error = true;
		$errmsg = "Check your inputs";
	}
}

//Message d'alerte si necessaire
if($errmsg != '') {
?>
	<div class="alert alert-<?= $error ? 'danger' : 'success' ?> alert-dismissible fade show" role="alert">
	<strong><?= $error ? "Error" : "OK" ?></strong> <?= htmlentities($errmsg) ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php
}


?>
<h1>Change your password</h1>
<div class="row">
	<div class="mx-auto col-3">
		<!-- Formulaire de modification de mdp  -->
		<form method="post">
			<div class="form-group">
				<label for="currentPassword">Current password</label>
				<input type="password" class="form-control" id="currentPassword" name="currentPassword" />
			</div>
			<div class="form-group">
				<label for="password">New Password</label>
				<input type="password" class="form-control" id="password" name="password" />
			</div>
			<div class="form-group">
				<label for="confirmPassword">New Password (confirm)</label>
				<input type="password" class="form-control" id="confirmPassword" name="confirmPassword" />
			</div>
			<center>
			<button type="submit" class="btn btn-outline-warning">Change password</button>
			</center>
		</form>
	</div>
</div>
<?php

require 'inc/foot.php';



