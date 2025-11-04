<?php 

$commandName = $argv[1] ?? null;    // make-controller ou make-model
$controllerName = $argv[2] ?? null; // Le nom du controller à créer, par exemple Admin ou Home

if($commandName == null){
    echo "Vous devez préciser une commande\n";
    exit;
}

switch ($commandName) {
    case 'make-controller':
        echo "Création du controller : $controllerName\n";
        createController($controllerName);
        break;

    case 'make-model':
        echo "Création du model : $controllerName\n";
        createModel($controllerName);
        break;

    default:
        echo "Commande inconnue\n";
        break;
}

function createController(string $controllerName){
    // TODO : Créer le fichier controller dans app/controllers
}

function createModel(string $modelName){
    // TODO : Créer le fichier model dans app/models
}