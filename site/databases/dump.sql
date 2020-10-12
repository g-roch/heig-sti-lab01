----
-- phpLiteAdmin database dump (https://bitbucket.org/phpliteadmin/public)
-- phpLiteAdmin version: 1.9.6
-- Exported: 2:41pm on October 12, 2020 (UTC)
-- database file: /usr/share/nginx/databases/database.sqlite
----
BEGIN TRANSACTION;

----
-- Table structure for users
----
CREATE TABLE 'users' (
	'id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
	'username' TEXT NOT NULL UNIQUE, 
	'password' TEXT NOT NULL, 
	'isActive' BOOLEAN NOT NULL DEFAULT 1, 
	'isAdmin' BOOLEAN NOT NULL DEFAULT 0
);

----
-- Data dump for users, a total of 5 rows
----
INSERT INTO "users" ("id","username","password","isActive","isAdmin") VALUES ('1','alice','$2y$10$.f4P6db7gXAHdM7wyRv20OnZeJZxUsYPLEkk2KIYNq/jRS48bjnbq','1','1');
INSERT INTO "users" ("id","username","password","isActive","isAdmin") VALUES ('2','bob','$2y$10$Kgs0e3Rvto4.m46E.Njs1u10eT7YFHWASef8t1yzZikw0Zp9MD3oW','1','');
INSERT INTO "users" ("id","username","password","isActive","isAdmin") VALUES ('3','bobi','$2y$10$7RkBZX/WpwAxycRJEspm3.rRcbKY1mDWdQM7Wc1HPp/FpS2Fe/KVq','1','');
INSERT INTO "users" ("id","username","password","isActive","isAdmin") VALUES ('4','Alicette','$2y$10$H/0DGztgJSOvmvH4vaSHnuDhjolONvd8q/gfVQk8N3Yo.AWaGcE/q','1','');
INSERT INTO "users" ("id","username","password","isActive","isAdmin") VALUES ('5','Test','$2y$10$Motc6fzWCJ3hnGkwFZr3TuNA7kEbQyQVUT7q1DKlop8BUM/4PEX0u','1','1');

----
-- Table structure for messages
----
CREATE TABLE 'messages' (
	'id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
	'subject' TEXT NOT NULL, 
	'body' TEXT NOT NULL, 
	'dateSent' DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
	'dateReceive' DATETIME DEFAULT NULL, 
	'from' INTEGER NOT NULL, 
	'to' INTEGER NOT NULL
);

----
-- Data dump for messages, a total of 14 rows
----
INSERT INTO "messages" ("id","subject","body","dateSent","dateReceive","from","to") VALUES ('5','NOOON','DONT DO THAT','2020-10-02 14:08:15',NULL,'2','1');
INSERT INTO "messages" ("id","subject","body","dateSent","dateReceive","from","to") VALUES ('8','Hey','IT''S YOUR FIRST DAY HERE. WELCOME MY FRIEND !!!','2020-10-02 14:26:59',NULL,'2','3');
INSERT INTO "messages" ("id","subject","body","dateSent","dateReceive","from","to") VALUES ('12','RE: NOOON','asdf
<blockquote>
DONT DO THAT
</blockquote>
','2020-10-02 14:45:11',NULL,'1','2');
INSERT INTO "messages" ("id","subject","body","dateSent","dateReceive","from","to") VALUES ('13','DESAPPOINTED','COMMENT AS-TU OSééééééééééé :(','2020-10-02 14:45:15',NULL,'2','1');
INSERT INTO "messages" ("id","subject","body","dateSent","dateReceive","from","to") VALUES ('15','RE: NOOON','OUIIIII
<blockquote>
erwerwerw
<blockquote>
asdf
<blockquote>
DONT DO THAT
</blockquote>

</blockquote>

</blockquote>
','2020-10-02 14:47:11',NULL,'1','2');
INSERT INTO "messages" ("id","subject","body","dateSent","dateReceive","from","to") VALUES ('16','Test','Bonjour','2020-10-07 09:58:23',NULL,'1','3');
INSERT INTO "messages" ("id","subject","body","dateSent","dateReceive","from","to") VALUES ('20','ddd','ddd','2020-10-12 12:15:24',NULL,'2','4');
INSERT INTO "messages" ("id","subject","body","dateSent","dateReceive","from","to") VALUES ('22','qw','qwe','2020-10-12 12:15:30',NULL,'1','3');
INSERT INTO "messages" ("id","subject","body","dateSent","dateReceive","from","to") VALUES ('23','f','g','2020-10-12 12:16:57',NULL,'2','4');
INSERT INTO "messages" ("id","subject","body","dateSent","dateReceive","from","to") VALUES ('28','RE: On test','sadasd
<blockquote>
cc
<blockquote>
Couucou
</blockquote>

</blockquote>
','2020-10-12 12:27:08',NULL,'1','2');
INSERT INTO "messages" ("id","subject","body","dateSent","dateReceive","from","to") VALUES ('29','RE: On test','cc
<blockquote>
Couucou
</blockquote>
','2020-10-12 12:27:13',NULL,'2','1');
INSERT INTO "messages" ("id","subject","body","dateSent","dateReceive","from","to") VALUES ('30','RE: qw','
<blockquote>
qwe
</blockquote>
','2020-10-12 12:27:15',NULL,'3','1');
INSERT INTO "messages" ("id","subject","body","dateSent","dateReceive","from","to") VALUES ('31','RE: On test','cxc
<blockquote>
sadasd
<blockquote>
cc
<blockquote>
Couucou
</blockquote>

</blockquote>

</blockquote>
','2020-10-12 12:27:28',NULL,'2','1');
INSERT INTO "messages" ("id","subject","body","dateSent","dateReceive","from","to") VALUES ('36','tete','tete','2020-10-12 12:31:37',NULL,'2','5');

----
-- structure for index sqlite_autoindex_users_1 on table users
----
;
COMMIT;
