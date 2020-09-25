<?php

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

$sql = "CREATE TABLE 'messages' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'subject' TEXT NOT NULL, 'body' TEXT NOT NULL, 'dateSent' DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 'dateReceive' DATETIME DEFAULT NULL, 'from' INTEGER NOT NULL);";
$sql = "CREATE TABLE 'users' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'isActive' BOOLEAN NOT NULL DEFAULT 0, 'isAdmin' BOOLEAN NOT NULL DEFAULT 0, 'username' TEXT NOT NULL DEFAULT '', 'password' TEXT NOT NULL DEFAULT '');";

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
