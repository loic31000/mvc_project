<?php
// php app/cli/cli.php make-controller Admin 
//php app/cli/cli.php make-controller User


$commandName = $argv[1] ?? null;    // make-controller ou make-model
$controllerName = $argv[2] ?? null; // Le nom du controller ou model

if ($commandName === null) {
    echo "Vous devez préciser une commande\n";
    exit;
}

switch ($commandName) {
    case 'make-controller':
        if ($controllerName === null) {
            echo "Vous devez préciser le nom du controller\n";
            exit;
        }
        echo "Création du controller : $controllerName\n";
        createController($controllerName);
        break;

    case 'make-model':
        if ($controllerName === null) {
            echo "Vous devez préciser le nom du model\n";
            exit;
        }
        echo "Création du model : $controllerName\n";
        createModel($controllerName);
        break;

    default:
        echo "Commande inconnue\n";
        break;
}

/**
 * Fonction pour créer un contrôleur à partir du template
 */
function createController(string $controllerName) {
    $templatePath = __DIR__ . '/TemplateController';
    $template = file_get_contents($templatePath);
    $template = str_replace('[CONTROLLER_NAME]', $controllerName, $template);
    $filePath = __DIR__ . '/../controllers/' . $controllerName . 'Controller.php';
    file_put_contents($filePath, $template);
    echo "Controller {$controllerName}Controller créé à {$filePath}\n";
}

/**
 * Fonction pour créer un modèle a partir du template
 */
function createModel(string $modelName) {
    $templatePath = __DIR__ . '/TemplateModel';
    $template = file_get_contents($templatePath);
    $template = str_replace('[MODEL_NAME]', $modelName, $template);
    $filePath = __DIR__ . '/../models/' . $modelName . 'Model.php';
    file_put_contents($filePath, $template);
    echo "Model {$modelName}Model créé à {$filePath}\n";
}



// # Créer le contrôleur AdminController
// php app/cli/cli.php make-controller Admin

// # Créer le contrôleur UserController
// php app/cli/cli.php make-controller User

// # Créer un modèle AdminModel
// php app/cli/cli.php make-model Admin

