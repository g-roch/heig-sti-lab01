<?php


$pdo = new PDO(
	'sqlite:/usr/share/nginx/databases/database.sqlite',
	null,
	null,
	[
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NAMED,
	]
);

$sql[] = <<<'SQL'
DROP TABLE IF EXISTS 'users';
SQL;
$sql[] = <<<'SQL'
DROP TABLE IF EXISTS 'messages';
SQL;
$sql[] = <<<'SQL'
CREATE TABLE 'users' (
	'id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
	'username' TEXT NOT NULL UNIQUE, 
	'password' TEXT NOT NULL, 
	'isActive' BOOLEAN NOT NULL DEFAULT 1, 
	'isAdmin' BOOLEAN NOT NULL DEFAULT 0
);
SQL;
$sql[] = <<<'SQL'
INSERT INTO "users" ("id","isActive","isAdmin","username","password") VALUES ('1','1','1','alice','$2y$10$anjvRzgXh3uf8.izVWrobOCP4sjt3VFuZrfud/ZHUon9L..SXimuu');
SQL;
$sql[] = <<<'SQL'
CREATE TABLE 'messages' (
	'id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
	'subject' TEXT NOT NULL, 
	'body' TEXT NOT NULL, 
	'dateSent' DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
	'dateReceive' DATETIME DEFAULT NULL, 
	'from' INTEGER NOT NULL, 
	'to' INTEGER NOT NULL
);
SQL;

echo "<pre>";
foreach($sql as $query) {
	echo "Exec ", htmlentities($query), "<br />";
	echo "result = ";
	var_dump($pdo->query($query));
}
