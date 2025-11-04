<?php
class ProductModel
{
    // Instance de la connexion à la base de données
    private PDO $bdd;

    // Requête préparée pour récupérer tous les produits avec limite
    private PDOStatement $getProducts;

    // Requête préparée pour récupérer un produit par son ID
    private PDOStatement $getProductById;

    // Requête préparée pour insérer un nouveau produit
    private PDOStatement $insertProduct;

    // Requête préparée pour supprimer un produit par ID
    private PDOStatement $deleteProduct;

    // Requête préparée pour mettre à jour un produit existant
    private PDOStatement $updateProduct;

    // Constructeur qui initialise la connexion et prépare les requêtes SQL
    function __construct()
    {
        // Connexion à la base de données MySQL avec PDO
        $this->bdd = new PDO("mysql:host=bdd;dbname=app-database", "root", "root");

        // Préparer la requête pour récupérer les produits avec limite dynamique
        $this->getProducts = $this->bdd->prepare("SELECT * FROM Produit LIMIT :limit");

        // Préparer la requête pour récupérer un produit via son ID
        $this->getProductById = $this->bdd->prepare("SELECT * FROM Produit WHERE id = :id");

        // Préparer la requête pour insérer un nouveau produit
        $this->insertProduct = $this->bdd->prepare("INSERT INTO Produit (name, price, image) VALUES (:name, :price, :image)");

        // Préparer la requête pour supprimer un produit selon son ID
        $this->deleteProduct = $this->bdd->prepare("DELETE FROM Produit WHERE id = :id");

        // Préparer la requête pour mettre à jour un produit selon son ID
        $this->updateProduct = $this->bdd->prepare("UPDATE Produit SET name = :name, price = :price, image = :image WHERE id = :id");
    }

    /**
     * Récupérer tous les produits limités en nombre
     * @param int $limit nombre max de produits retournés, par défaut 50
     * @return array tableau d'instances ProductEntity
     */
    public function getAll(int $limit = 50): array
    {
        // Lier la valeur du paramètre limit en précisant le type entier
        $this->getProducts->bindValue("limit", $limit, PDO::PARAM_INT);
        // Exécuter la requête préparée
        $this->getProducts->execute();
        // Récupérer tous les résultats sous forme de tableau
        $rawProducts = $this->getProducts->fetchAll();

        // Initialiser un tableau pour stocker les entités produit formatées
        $productsEntity = [];
        foreach ($rawProducts as $rawProduct) {
            // Pour chaque résultat brut, créer une nouvelle entité ProductEntity
            $productsEntity[] = new ProductEntity(
                $rawProduct["name"],
                $rawProduct["price"],
                $rawProduct["image"],
                $rawProduct["id"]
            );
        }

        // Retourner le tableau d'entités produits
        return $productsEntity;
    }

    /**
     * Récupérer un produit par son ID
     * @param int $id identifiant du produit
     * @return ProductEntity|null retourne l'entité produit ou null si non trouvé
     */
    public function get(int $id): ProductEntity|null
    {
        // Lier le paramètre ID à la requête préparée en type entier
        $this->getProductById->bindValue(":id", $id, PDO::PARAM_INT);
        // Exécuter la requête
        $this->getProductById->execute();
        // Récupérer la ligne retournée sous forme de tableau associatif
        $raw = $this->getProductById->fetch(PDO::FETCH_ASSOC);

        // Si aucun résultat, retourner null
        if ($raw === false) {
            return null;
        }
        // Sinon, retourner une nouvelle instance ProductEntity avec les données
        return new ProductEntity($raw["name"], $raw["price"], $raw["image"], $raw["id"]);
    }

    /**
     * Ajouter un nouveau produit en base de données
     * @param string $name nom du produit
     * @param float $price prix du produit
     * @param string $image URL ou chemin de l'image
     * @return void
     */
    public function add(string $name, float $price, string $image): void
    {
        // Lier les valeurs aux paramètres de la requête préparée
        $this->insertProduct->bindValue(":name", $name, PDO::PARAM_STR);
        $this->insertProduct->bindValue(":price", $price); // float sans type spécifique PDO
        $this->insertProduct->bindValue(":image", $image, PDO::PARAM_STR);
        // Exécuter la requête d'insertion
        $this->insertProduct->execute();
    }

    /**
     * Supprimer un produit par son ID
     * @param int $id identifiant du produit à supprimer
     * @return void
     */
    public function del(int $id): void
    {
        // Lier l'id à la requête préparée pour suppression
        $this->deleteProduct->bindValue(":id", $id, PDO::PARAM_INT);
        // Exécuter la suppression
        $this->deleteProduct->execute();
    }

    /**
     * Modifier un produit existant
     * @param int $id identifiant du produit à modifier
     * @param string|null $name nouveau nom (optionnel)
     * @param float|null $price nouveau prix (optionnel)
     * @param string|null $image nouvelle image (optionnelle)
     * @return ProductEntity|null le produit modifié ou null si introuvable
     */
    public function edit(int $id, ?string $name = null, ?float $price = null, ?string $image = null): ProductEntity|null
    {
        // Récupérer l'entité produit existante par son id
        $product = $this->get($id);
        // Si produit non trouvé, retourner null
        if ($product === null) {
            return null;
        }

        // Mettre à jour les propriétés seulement si un nouveau paramètre est fourni
        if ($name !== null) {
            $product->setName($name);
        }
        if ($price !== null) {
            $product->setPrice($price);
        }
        if ($image !== null) {
            $product->setImage($image);
        }

        // Lier les valeurs modifiées y compris l'id à la requête préparée d'update
        $this->updateProduct->bindValue(":id", $id, PDO::PARAM_INT);
        $this->updateProduct->bindValue(":name", $product->getName(), PDO::PARAM_STR);
        $this->updateProduct->bindValue(":price", $product->getPrice());
        $this->updateProduct->bindValue(":image", $product->getImage(), PDO::PARAM_STR);
        // Exécuter la requête de mise à jour
        $this->updateProduct->execute();

        // Retourner l'entité produit modifiée
        return $product;
    }
}

// Classe représentant une entité Produit avec ses propriétés et méthodes
class ProductEntity
{
    private $name;  // Nom du produit
    private $price; // Prix du produit
    private $image; // Image / URL de l'image
    private $id;    // Identifiant unique (clé primaire)

    // Constantes pour validation et valeur par défaut image
    private const NAME_MIN_LENGTH = 3;
    private const PRICE_MIN = 0;
    private const DEFAULT_IMG_URL = "/public/images/default.png";

    /**
     * Constructeur initialise une nouvelle entité produit
     */
    function __construct(string $name, float $price, string $image, int $id = null)
    {
        // Utilisation des setters pour valider et affecter les valeurs
        $this->setName($name);
        $this->setPrice($price);
        $this->setImage($image);
        $this->id = $id; // id peut être null si nouveau produit pas encore en base
    }

    // Setter pour nom, impose une longueur minimale
    public function setName(string $name)
    {
        if (strlen($name) < $this::NAME_MIN_LENGTH) {
            throw new Error("Name is too short minimum length is " . $this::NAME_MIN_LENGTH);
        }
        $this->name = $name;
    }

    // Setter pour prix, vérifie qu'il est positif ou nul
    public function setPrice(float $price)
    {
        if ($price < 0) {
            throw new Error("Price is too short minimum price is " . $this::PRICE_MIN);
        }
        $this->price = $price;
    }

    // Setter pour image, met une image par défaut si chaine vide
    public function setImage(string $image)
    {
        if (strlen($image) <= 0) {
            $this->image = $this::DEFAULT_IMG_URL;
        } else {
            $this->image = $image;
        }
    }

    // Getters simples pour chaque propriété
    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
