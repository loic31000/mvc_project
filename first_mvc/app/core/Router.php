<?php
require_once(__DIR__."/../controllers/ProductController.php");
require_once(__DIR__."/../controllers/HomeController.php");
require_once(__DIR__."/../controllers/NotFoundController.php");

class Router {
    public static function getController(string $controllerName) {
        if ($controllerName === null || $controllerName === '') {
            throw new Error("Controller name is empty or null");
        }

        switch ($controllerName) {
            case 'product':
                return new ProductController();
            case '':
                return new HomeController();
            default:
                // Si aucune route de match
                return new NotFoundController();
        }
    }
}
?>
