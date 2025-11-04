<?php
require_once(__DIR__."/../models/ProductModel.php");

class App{
    public static function start(){
        $productModel = new ProductModel();
        $products = $productModel->getAll();
        var_dump($products);
        foreach($products as $product){
            // Product est du type ProductEntity
            var_dump($product->getName());
            // attention à bien ajouter des lignes dans la table Produit
        }
    }
}