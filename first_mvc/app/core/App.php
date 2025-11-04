<?php
class App{
    public static function start(){
        echo "App";
    }
    
}

require_once(__DIR__."/../models/ProductModel.php");

class App{
    public static function start(){
        var_dump(new ProductEntity("Billy",34,"/public/images/billy.png"));
    }
}