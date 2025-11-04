<?php
// Je vais créer les routes /product/... j'ai donc besoin
// de controleur ProductController
require_once(__DIR__."/../controllers/ProductController.php");

class Router{
    public static function getController(string $controllerName){
        switch ($controllerName) {
            // Si la route est /product 
            case 'product':
                // Je renvoi le controleur ProductController
                return new ProductController();
                break;
            default:
                break;
        }
    }
}