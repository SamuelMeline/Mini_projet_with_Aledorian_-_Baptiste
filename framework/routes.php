<?php

/*
    Fichier de routing :
    
    Il contient toutes les url de nos pages (tout ce qui se trouve derrrière index.php).
    Chaque url est associée à un nom de contrôleur et la méthode à appeler.
*/

return [
    '/' => [
        'App\Controllers\HomeController',
        'index'
    ],
        '/events' => [
        'App\Controllers\EventsListController',
        'index'
    ],
];