<?php 
require_once 'inc/bootstrap.php';

require 'inc/head.php';

$userid = $_SESSION['user']['userid'];

var_dump($_POST);
/*Vérifie l'effectif du message*/
if(isset(
	$_POST['to'],
	$_POST['subject'],
	$_POST['body']) &&
	is_numeric($_POST['to']) &&
	$_POST['subject'] != "" && 
	$_POST['body'] != ""
){

	$statement = $pdo->query("INSERT INTO messages (`subject`,`body`,`from`,`to`) VALUES ('$_POST[subject]','$_POST[body]','$userid','$_POST[to]')");
	
	$message = $statement?'Message sent':'Message not sent';
	$title = $statement?'Success':'Error';
	$color = $statement?'success':'danger';
?>
<div class="alert alert-<?=$color?> alert-dismissible fade show" role="alert">
  <strong><?= $title ?></strong> <?= $message ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php
}


$users = $pdo->query('SELECT `id`, `username` FROM `users`');

$subject = '';
$body = '';
$to = '';

/*Gestion de la réponse d'un message*/
if(isset($_GET['replyto']) && is_numeric($_GET['replyto'])) {
	$statement = $pdo->query("SELECT * FROM `messages` WHERE `id` = '$_GET[replyto]'");
	$a = $statement->fetch();

	/*Vérification qu'un message a été envoyé à l'utilisateur connecté*/
	if(is_array($a) && $a['to'] == $_SESSION['user']['userid']) {
		if(substr($a['subject'], 0, 4) != 'RE: ') {
			$subject = "RE: $a[subject]";
		} else {
			$subject = $a['subject'];
		}
		$to = $a['from'];
		$body = "\n\n<blockquote>\n$a[body]\n</blockquote>\n";
	}

}

?>
<h1>Send message</h1>
<div class="row">
	<div class="mx-auto col-10">
		<!--Formulaire d'envoi d'un message -->
		<form method="post" action="?">
			<div class="row">
				<div class="form-group col-3">
					<label for="to">To</label>
<?php if(isset($_GET['replyto'])): ?>
<input type="hidden" name="to" value="<?= $to ?>" />
<?php endif; ?>
					<select class="form-control" <?= isset($_GET['replyto']) ? 'disabled' : '' ?>  id="to" name="to">
						<?php foreach($users as $user) if($user['id'] != $userid ) if($user['id'] == $to): ?>
							<option selected value="<?= htmlentities($user['id']) ?>"><?= htmlentities($user['username']) ?></option>
						<?php else: ?>
							<option value="<?= htmlentities($user['id']) ?>"><?= htmlentities($user['username']) ?></option>
						<?php endif; ?>
					</select>	
				</div>
				<div class="form-group col">
					<label for="subject">Subject</label>
					<input type="text" class="form-control" id="subject" name="subject" value="<?=htmlentities($subject)?>">
				</div>
			</div>
			<div class="form-group">
				<label for="body">Body</label>
				<textarea class="form-control" id="body" rows="15" name="body"><?= htmlentities($body) ?></textarea>
			</div>
			<center>
			<button type="submit" class="btn btn-primary">Send</button>
			</center>
		</form>
	</div>
</div>

<?php

require 'inc/foot.php';


