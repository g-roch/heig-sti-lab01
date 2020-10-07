# STI - Projet 1, Manuel 

**Auteurs** : Gwendoline Dössegger & Gabriel Roch

**Date** : 02.10.2020


## Manuel d'installation et lancement

### Lancement du serveur

Pour installer et lancer l'application il suffit de lancer les commandes suivantes : 

```shell
git clone https://github.com/g-roch/heig-sti-lab01.git
cd heig-sti-lab01
make start
```

### Lancement personnalisé du server

Pour changer le port d'écoute du serveur il suffit de definir la variable `PORT` lors du `make start`, 
par défaut il se lance sur le port 8080.

```shell
make start PORT=8080
```

### Installation de la base de donnée

Pour installer la base de donnée, chargé la page http://127.0.0.1:8080/install.php ce fichier créait 
la base de donnée avec comme utilisateur administrateur `alice` avec le mot de passe `admin`.

**Ce fichier doit être supprimer une fois l'installation faite**

## Manuel d'utilisation de l'application

### Connection (`login.php`)

Lors que l'utilisateur veux accéder à une page, la page de login lui est afficher s'il n'est pas encore connecté.

Sa session à une durée de vie maximal de 1h, et de 30 minutes sans activité.

Si l'utilisateur essaie d'accèder à une page auquel il n'a pas le droit, une page vide sera affiché.

### Reception des message (`mailbox.php`)

La page *Mailbox* permet de visualiser les messages reçu. Pour chaque message, l'utilisateur peux en voir 
les détails, y répondre ou le supprimer.

#### Répondre à un message

Le boutton `reply` permet de répondre à un message, la réponse est simplement un noveau message avec `RE: ` ajouter 
au début du sujet, et la corps du message précédent cité dans le corps du nouveau message.

## Envoyer un nouveau message (`send.php`)

La page *New message* permet d'envoyer un nouvea message, le destinataire doit être choisi dans la liste déroulante.
le sujet et le corps du message doivent être renseigner. Lors de l'envoi, un popup s'affiche pour indiquer si l'envoi s'est
bien passé.

### Changement de mot de passe (`password.php`)

La page *Change password* permet à l'utilisateur de changer son mot de passe, pour cela il doit rentrer 
son mot de passe actuel et deux fois le mot de passe désiré.

### Adminsitration des utilisateurs (`users.php`)

La page *Users* permet de lister les utilisateurs du site web. Cette page n'est accessible que pour les utilisateurs avec
le droit admin. 

Pour chaque utilisateur, l'administrateur peut changer son mot de passe, désactiver/activer le compte ou lui donner/retirer
les droits d'administration. Il peut également supprimer definitivement un compte.

Les administrateurs peuvent également créer des nouveaux utilisateurs sur cette page.

-------

Si vous utilisez l'image Docker proposée pour le cours, vous pouvez copier directement le repertoire "site" et son contenu (explications dans la donnée du projet).

Le repertoire "site" contient deux repertoires :

    - databases
    - html

Le repertoire "databases" contient :

    - database.sqlite : un fichier de base de données SQLite

Le repertoire "html" contient :

    - exemple.php : un fichier php qui réalise des opérations basiques SQLite sur le fichier contenu dans le repertoire databases
    - helloworld.php : un simple fichier hello world pour vous assurer que votre container Docker fonctionne correctement
    - phpliteadmin.php : une interface d'administration pour la base de données SQLite qui se trouve dans le repertoire databases

Le mot de passe pour phpliteadmin est "admin".
