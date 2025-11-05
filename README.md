1. Lancez le projet avec Docker Compose :

docker compose up --build

2. Créez un table Product dans phpmyadmin:

    Allez à l'adresse :

http://localhost:8081

utilisez les identifiants suivants :

    Utilisateur : root
    Mot de passe : root

    Si besoin le host est bdd et le port 3306

    Executez la requête SQL suivante :

CREATE TABLE `app-database`.`Produit` (`id` INT NOT NULL AUTO_INCREMENT , `name` TINYTEXT NOT NULL , `price` FLOAT NOT NULL , `image` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; 

3. Accédez à l'application :

Rendez vous dans votre navigateur à l'adresse :

http://localhost:8080

Voyez la liste des produits dans la console : alt text
