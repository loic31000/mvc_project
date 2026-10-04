# MVC Project

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Apache-D22128?style=for-the-badge&logo=apache&logoColor=white" alt="Apache">
  <img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker">
  <img src="https://img.shields.io/badge/MVC-architecture-555555?style=for-the-badge" alt="MVC">
</p>

Exercice PHP consacré à la construction d'une architecture MVC simple avec routeur, contrôleurs, modèle PDO et vues.

## Fonctionnement vérifié

Le projet contient :

- un routeur qui sélectionne un contrôleur à partir de l'URL ;
- un `HomeController` ;
- un `ProductController` ;
- un `ProductModel` utilisant PDO ;
- des opérations de lecture, ajout, modification et suppression prévues dans le modèle produit ;
- une vue d'accueil, une vue produit et une page 404 ;
- un environnement Docker avec Apache/PHP, MySQL et phpMyAdmin.

## Structure

```text
mvc_project/
└── first_mvc/
    ├── app/
    │   ├── cli/
    │   ├── controllers/
    │   ├── core/
    │   ├── models/
    │   ├── public/
    │   └── views/
    ├── compose.yaml
    └── web/
        └── Dockerfile
```

## Lancement

```bash
git clone https://github.com/loic31000/mvc_project.git
cd mvc_project/first_mvc
docker compose up --build
```

L'application est exposée sur `http://localhost:8080` et phpMyAdmin sur `http://localhost:8081`.

## CLI interne

Le dossier `first_mvc/app/cli/` contient un petit générateur en ligne de commande.

Depuis `first_mvc/` :

```bash
php app/cli/cli.php make-controller Admin
php app/cli/cli.php make-model Admin
```

Commandes définies dans `cli.php` :

- `make-controller <Nom>` : tente de créer `app/controllers/<Nom>Controller.php` à partir de `TemplateController` ;
- `make-model <Nom>` : crée une base de modèle dans `app/models/<Nom>Model.php` à partir de `TemplateModel`.

### État actuel du générateur

Le générateur de modèle est bien prévu pour remplacer le placeholder `[MODEL_NAME]`, mais le template reste volontairement à compléter avec les colonnes et requêtes SQL du modèle.

Le générateur de contrôleur présente actuellement deux incohérences dans le dépôt :

- le fichier versionné s'appelle `TemplateController ` avec un espace final, alors que `cli.php` cherche `TemplateController` sans espace ;
- le contenu du template utilise `Admin_Controller` et ne contient pas le placeholder `[CONTROLLER_NAME]` que `cli.php` tente de remplacer.

La commande `make-controller` est donc documentée telle qu'elle existe dans le code, mais elle nécessite une correction avant d'être considérée comme fonctionnelle.

## Base de données

Le modèle se connecte à la base `app-database` et attend une table `Produit`.

Le dépôt ne contient pas de migration ou de fichier SQL d'initialisation. La table doit donc être créée manuellement.

Structure utilisée par le modèle :

```sql
CREATE TABLE Produit (
    id INT NOT NULL AUTO_INCREMENT,
    name TINYTEXT NOT NULL,
    price FLOAT NOT NULL,
    image TEXT NOT NULL,
    PRIMARY KEY (id)
);
```

Les identifiants de base présents dans le code et dans Docker sont destinés à l'environnement local de cet exercice.

## État du projet

Le dépôt est un exercice d'architecture MVC. Il ne contient actuellement ni tests automatisés ni fichier de licence.
