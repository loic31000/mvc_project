<?php
require_once(__DIR__ . "/../models/ProductModel.php");
require_once(__DIR__ . "/../controllers/ProductController.php");
require_once(__DIR__ . "/Router.php");

class App
{
    public static function start()
    {
        $productModel = new ProductModel();
        $products = $productModel->getAll();


        $controller = new ProductController();
        $controller->show([3]);

        $controller = Router::getController("product");
        $controller->show([3]);



        console($products);
        foreach ($products as $product) {
            // Product est du type ProductEntity
            console($product->getName());
            // attention à bien ajouter des lignes dans la table Produit
        }
    }
}
