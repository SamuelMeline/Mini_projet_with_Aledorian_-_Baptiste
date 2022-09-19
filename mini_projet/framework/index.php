<?php

use Libraries\Http\NotFoundException;
use App\Controllers\ErrorController;
use Libraries\Auth\User;

try {
    session_start();
    
    // Autoloader
    spl_autoload_register(function ($className) {
        require str_replace("\\", "/", $className) . ".php";
    });
    
    // Chargement du fichier qui contient les fonctions utilitaires
    require 'utils.php';
    
    // Récupération de la route actuelle et des routes de l'application
    $route = $_SERVER['PATH_INFO'] ?? '/';
    $routes = require 'routes.php';
    
    // Si la route n'existe pas on déclenche une erreur 404
    if (! isset($routes[$route])) {
        throw new NotFoundException("La route demandée n'existe pas");
    }
    
    // Instanciation dynamique du contrôleur
    list($controllerName, $method) = $routes[$route];
    $controller = new $controllerName();
    $controller->$method();
} catch (NotFoundException $e) {
    // Gestion de la page 404
    $controller = new ErrorController();
    $controller->show404();
} catch (Exception $e) {
    // Gestion des autres erreurs

    $user = new User();

    var_dump($e->getMessage());
    exit();

    http_response_code(500);
    $template = 'errors/500.phtml';
    require 'App/Views/layout.phtml';
    
    // Enregistrement de l'erreur dans un fichier de log
    $now = new DateTime();
    $content = $now->format('Y-m-d H:i:s') . " : " . $e->getMessage() . "\n";
    file_put_contents("error.log", $content, FILE_APPEND);
}