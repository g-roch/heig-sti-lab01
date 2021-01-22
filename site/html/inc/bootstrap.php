<?php


header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Permitted-Cross-Domain-Policies: none');
header('Referrer-Policy: no-referrer');
header('X-Content-Type-Options: nosniff');


ini_set('session.cookie_httponly', true);
// ↓ don't work with php 5.5.9
//ini_set('session.cookie_samesite', "Strict");

set_exception_handler(function($e) {
?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error <?= htmlentities($e->getCode()) ?></strong> <?= htmlentities($e->getMessage()) ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
<!--    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>-->
    <script src="/js/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<!--    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
    <script src="/js/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="/js/bootstrap.min.js"></script>
</div>
<?php
});

define("MAX_CONNEXION_TIME", 60*60*1);
define("MAX_WAIT_TIME", 60*30);

$pdo = new PDO(
	'sqlite:/usr/share/nginx/databases/database.sqlite',
	null,
	null,
	[
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NAMED,
	]
);


session_start();
$connected = 
	isset($_SESSION['user'])
	&& $_SESSION['user']['connexionTime'] + MAX_CONNEXION_TIME > time()
	&& $_SESSION['user']['lastViewTime'] + MAX_WAIT_TIME > time();

if(isset($_POST['username'], $_POST['password'])) {
	$statement = $pdo->prepare('SELECT * FROM `users` WHERE `users`.`username` = :username');
	$statement->execute([':username' => $_POST['username']]);
	$user = $statement->fetch();
	if(is_array($user)) {
		if(password_verify($_POST['password'], $user['password'])) {
			$connected = true;
			$_SESSION['user']['userid'] = $user['id'];
			$_SESSION['user']['username'] = $user['username'];
			$_SESSION['user']['isActive'] = $user['isActive'];
			$_SESSION['user']['isAdmin'] = $user['isAdmin'];
			$_SESSION['user']['connexionTime'] = time();
			$_SESSION['user']['lastViewTime'] = time();
		}
	}
}

define('CONNECTED', $connected && $_SESSION['user']['isActive']);
define('ADMIN', $connected && $_SESSION['user']['isActive'] && $_SESSION['user']['isAdmin']);

if(!CONNECTED) {
	require __DIR__ . '/../login.php';
	exit();
}
