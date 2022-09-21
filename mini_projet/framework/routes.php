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
    '/events/create' => [
        'App\Controllers\EventsListController',
        'create'
    ],
    '/events/delete' => [
        'App\Controllers\EventsListController',
        'delete'
    ],
    '/event' => [
        'App\Controllers\EventsListController',
        'show'
    ],
    '/admin' => [
        'App\Controllers\AdminController',
        'index'
    ],
    '/editEvent' => [
        'App\Controllers\EventsListController',
        'edit'
    ],
    '/edit' => [
        'App\Controllers\EventsListController',
        'editForm'
    ],

    '/event/comment' => [
        'App\Controllers\EventsListController',
        'insertComment'
    ],  

    '/register' => [
        'App\Controllers\UserController',
        'register'
    ],
    '/login' => [
        'App\Controllers\UserController',
        'login'
    ],
    '/logout' => [
        'App\Controllers\UserController',
        'logout'
    ],
    '/comments/delete' => [
        'App\Controllers\EventsListController',
        'deleteComment'
    ],    
    '/event/registration' => [
        'App\Controllers\EventsListController',
        'registration'
    ],
    '/eventNear' => [
        'App\Controllers\EventsListController',
        'distance'
    ],
];