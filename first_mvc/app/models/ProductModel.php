<?
class ProductModel
{


    private PDO $bdd;
    private PDOStatement $getProducts;
    function __construct()
    {
        // Connexion à la base de donnée
        $this->bdd = new PDO("mysql:host=lamp-mysql;dbname=boutique", "root", "root");
        // Création d'une requête préparée qui récupère tout les produits
        $this->getProducts = $this->bdd->prepare("SELECT * FROM `Produit` 
        LIMIT :limit");
    }
    public function getAll(int $limit = 50): array
    {
        // Définir la valeur de LIMIT, par défault 50
        // LIMIT étant un INT ont n'oublie pas de préciser le type PDO::PARAM_INT.
        $this->getProducts->bindValue("limit", $limit, PDO::PARAM_INT);
        // Executer la requête
        $this->getProducts->execute();
        // Récupérer la réponse 
        $rawProducts = $this->getProducts->fetchAll();

        // Formater la réponse dans un tableau de ProductEntity
        $productsEntity = [];
        foreach ($rawProducts as $rawProduct) {
            $productsEntity[] = new ProductEntity(
                $rawProduct["name"],
                $rawProduct["price"],
                $rawProduct["image"],
                $rawProduct["id"]
            );
        }

        // Renvoyer le tableau de ProductEntity
        return $productsEntity;
    }

    public function get($id): ProductEntity|null
    {
        return NULL;
    }

    public function add(string $name, float $price, string $image): void
    {
    }

    public function del(int $id): void
    {
    }
    public function edit(
        int $id,
        string $name = NULL,
        float $price = NULL,
        string $image = NULL
    ): ProductEntity|null {
        return NULL;
    }
}

class ProductEntity
{
    private $name;
    private $price;
    private $image;
    private $id;
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

    private const NAME_MIN_LENGTH = 3;
    private const PRICE_MIN = 0;
    private const DEFAULT_IMG_URL = "/public/images/default.png";

    public function setName(string $name)
    {
        if (strlen($name) < $this::NAME_MIN_LENGTH) {
            throw new Error("Name is too short minimum 
            length is " . $this::NAME_MIN_LENGTH);
        }
        $this->name = $name;
    }
    public function setPrice(float $price)
    {
        if ($price < 0) {
            throw new Error("Price is too short minimum price is " . $this::PRICE_MIN);
        }
        $this->price = $price;
    }
    public function setImage(string $image)
    {
        if (strlen($image) <= 0) {
            $this->image = $this::DEFAULT_IMG_URL;
        }
        $this->image = $image;
    }

    function __construct(string $name, float $price, string $image, int $id = NULL)
    {
        $this->setName($name);
        $this->setPrice($price);
        $this->setImage($image);
        $this->id = $id;
    }
}