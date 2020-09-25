<?php

if(isset($_GET['logout'])) {
	session_start();
	unset($_SESSION['user']);
	header("Location: login.php");
	exit();
}

require_once 'inc/bootstrap.php';


require 'inc/head.php';
if(CONNECTED) {
?>
<h1>Bienvenue</h1>
<?php
} else {

?>
<div class="row">
	<div class="mx-auto col-3">
		<form method="post">
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" class="form-control" id="username" name="username" />
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" />
			</div>
			<center>
			<button type="submit" class="btn btn-outline-primary">Login</button>
			</center>
		</form>
	</div>
</div>
<?php
}

require 'inc/foot.php';


