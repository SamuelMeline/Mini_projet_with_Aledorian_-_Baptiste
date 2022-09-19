<?php

namespace Libraries\MVC;

use Libraries\Auth\User;
use Libraries\Session\Flashbag;

abstract class AbstractController
{
    /**
     * Affiche un template
     * 
     * @param string $template Nom du template à afficher
     * @param array $data Tableau contenant les variables à utiliser dans le template
     */
    public function render(string $template, array $data = []): void
    {
        // Création des variables à partir des clés contenues dans le tableau
        extract($data);
        
        $user = new User();
        $errors = new Flashbag();
        
        require 'App/Views/layout.phtml';
    }
    
    /**
     * Redirige vers une route spécifiée dans le fichier de route
     * 
     * @param string $path L'url de la route
     */
    public function redirect(string $path): void
    {
        header('Location: ' . url($path));
        exit();
    }
}