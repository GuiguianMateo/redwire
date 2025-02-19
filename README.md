<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# README
## InstallationPour réaliser une mise en place de l'application, vous devez avoir pré installer <a href="https://www.virtualbox.org/wiki/Downloads">Virtual Box</a>, <a href="https://developer.hashicorp.com/vagrant/install?product_intent=vagrant">Vagrant</a>, <a href="https://getcomposer.org/download">Composer</a>, ainsi que <a href="https://www.php.net/downloads">PHP</a>, <a href="https://nodejs.org/en">Node JS</a> et <a href="https://git-scm.com/downloads">Git</a>

## Mise en Place
### Importation du projet

Dans le dossier de votre choix, vous allez ouvrir git bash et y insérer la commande :

    git clone https://github.com/GuiguianMateo/redwire.git
    
### Téléchargement des fichiers suplémentaires

Après avoir installé votre project, il vous sufit de l'ouvrir depuis un IDE et d'y inséré dans un terminal :

    composer install

allez dans le répertoire homestead

    C:\Users\UserName> cd homestead
    C:\Users\UserName\Homestead> vagrant up
    C:\Users\UserName\Homestead> vagrant ssh
    vagrant@homestead:~$ cd code/redwire
    vagrant@homestead:~/code/redwire$
    
### Accès

Vous trouverez dans le fichier homestead.yaml à la racine du dossier Homestead quelque chose de similaire : 
    
    sites:
      - map: projet.test
        to: /home/vagrant/code/projet/public

    databases:
      - projet
      - projet_example

Et vous y rajouterez ceci

      - map: redwire.test
        to: /home/vagrant/code/redwire/public
...

      - redwire
      - redwire_example


Et dans le fichier host du répertoire : C:\Windows\System32\drivers\etc , vous y ajouterez cette ligne

    192.168.56.56 redwire.test

### Connexion

A la racine du projet, si un fichier .env est déjà créé, ouvrez le. Sinon vous allez le crée manuelement ".env" situer dans votre-répertoire/redwire
Vous copierez l'interrieur du fichier .env.exemple (à coter du fichier .env)
Et vous le collerez dans le fichier .env

Ensuite vous allez y modifier :

    DB_CONNECTION=mysql
    DB_HOST=192.168.56.56
    DB_PORT=3306
    DB_DATABASE=redwire
    DB_USERNAME=homestead
    DB_PASSWORD=secret

### Terminal
Dans le même tereminal précédent, lancez ces commandes :

     art migrate db:seed

## Lancement du projet  

    npm install vite
    npm run dev

cette commande est uniquement nécéssaire si vous vous retrouvez face à un problème d'affichage

### Connexion au comptes
Connectez-vous avec le compte que vous souaiter

    admin@gmail.com
    adminadmin

ou

    user@gmail.com
    useruser

