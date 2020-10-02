<?php
//Fichier envoyant l'entête html

	//Définition des menus
	$page = $_SERVER['SCRIPT_NAME'];
	$menu = [];
	$menu2 = [];
		
	if(CONNECTED) {
	 	$menu2['Logout'] = '/login.php?logout';
		$menu2[$_SESSION['user']['username']] = '#';
	} else {
	 	$menu2['Login'] = '/login.php';
	}
	
	if(CONNECTED) {
	 	$menu['Mailbox'] = '/mailbox.php';
	 	$menu['New message'] = '/send.php';
		$menu['Change password'] = '/password.php';
	}
	if(ADMIN) {
		$menu['Users'] = '/users.php';
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="/css/bootstrap.min.css" />

		<title>Hello, world!</title>
<style>
h1 { text-align:center}
blockquote { 
	margin-left: 1em;
	border: solid black 0;
	border-left-width: 1px;
	padding-left: 0.3em;
}
</style>
	</head>
	<body>
		<!-- Barre de navigation -->
		<nav class="navbar navbar-expand-md navbar-light bg-light">
			<a class="navbar-brand" href="#">iText</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav mr-auto">
					<?php foreach($menu as $name => $url): ?>
						<?php if(0 === strpos($url, $page)): ?>
							<li class="nav-item active">
								<a class="nav-link" href="<?= htmlentities($url) ?>"><?= htmlentities($name) ?> <span class="sr-only">(current)</span></a>
							</li>
						<?php else: ?>
							<li class="nav-item">
								<a class="nav-link" href="<?= htmlentities($url) ?>"><?= htmlentities($name) ?></a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
	
				</ul>
				<ul class="navbar-nav">
					<?php foreach($menu2 as $name => $url): ?>
						<?php if(0 === strpos($url, $page)): ?>
							<li class="nav-item active">
								<a class="nav-link" href="<?= htmlentities($url) ?>"><?= htmlentities($name) ?> <span class="sr-only">(current)</span></a>
							</li>
						<?php else: ?>
							<li class="nav-item">
								<a class="nav-link" href="<?= htmlentities($url) ?>"><?= htmlentities($name) ?></a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
	
				</ul>
			</div>
		</nav>
		<div class="container-fluid">
