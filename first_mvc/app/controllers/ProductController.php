<?php
require_once(__DIR__."/../models/ProductModel.php");

class ProductController{
    public function show(array $params = []){
        // Préparation de la variable $id à afficher dans la vue
        $id = $params[0];

        // Récupération d'un produit
        $productModel = new ProductModel();
        $product = $productModel->get($id);

        // Affichage de la vue
        require_once(__DIR__."/../views/single-product.php");
    }
}

