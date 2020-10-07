# STI - Projet 1, Manuel 

**Auteurs** : Gwendoline Dössegger & Gabriel Roch

**Date** : 02.10.2020


## Manuel d'installation et lancement

### Lancement du serveur

Pour installer et lancer l'application, il suffit de lancer les commandes suivantes : 

```shell
git clone https://github.com/g-roch/heig-sti-lab01.git
cd heig-sti-lab01
make start
```

### Lancement personnalisé du server

Pour changer le port d'écoute du serveur, il suffit de définir la variable `PORT` lors du `make start`. 
Par défaut, il se lance sur le port 8080.

```shell
make start PORT=8080
```

### Installation de la base de données

Pour installer la base de données, la page http://127.0.0.1:8080/install.php doit être chargée. Ce fichier crée 
la base de données avec comme utilisateur administrateur `alice` et le mot de passe `admin`.

**Ce fichier doit être supprimé une fois l'installation faite**

## Manuel d'utilisation de l'application

### Connection (`login.php`)

Lorsque l'utilisateur veut accéder à une page et qu'il n'est pas connecté la page de login lui est retournée.

Sa session a une durée de vie maximale de 1h, et de 30 minutes sans activité.

Si l'utilisateur essaie d'accèder à une page auquel il n'a pas le droit, une page vide sera affichée.

### Réception des messages (`mailbox.php`)

La page *Mailbox* permet de visualiser les messages reçus. Pour chaque message, l'utilisateur peut en voir 
le détail, y répondre ou le supprimer.

#### Répondre à un message

Le bouton `reply` permet de répondre à un message. La réponse est simplement un nouveau message avec comme sujet `RE: ` suivi du sujet précédent
et le corps du message précédent est cité dans le nouveau corps du message.

## Envoyer un nouveau message (`send.php`)

La page *New message* permet d'envoyer un nouveau message, le destinataire doit être choisi dans la liste déroulante.
le sujet et le corps du message doivent être renseignés. Lors de l'envoi, un popup s'affiche pour indiquer si l'envoi s'est
déroulé correctement.

### Changement de mot de passe (`password.php`)

La page *Change password* permet à l'utilisateur de changer son mot de passe. Pour cela, il doit rentrer 
son mot de passe actuel ainsi que deux fois le nouveau mot de passe.

### Adminsitration des utilisateurs (`users.php`)

La page *Users* permet de lister les utilisateurs du site web. Cette page n'est accessible que pour les utilisateurs ayant
le droit admin. 

Pour chaque utilisateur, l'administrateur peut changer son mot de passe, activer/désactiver le compte ou lui donner/retirer
les droits d'administration. Il peut également supprimer définitivement un compte.

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
