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
    '/posts/show' => [
        'App\Controllers\PostController',
        'show'
    ],
    '/posts/create' => [
        'App\Controllers\PostController',
        'create'
    ],
    '/posts/edit' => [
        'App\Controllers\PostController',
        'edit'
    ],
    '/posts/delete' => [
        'App\Controllers\PostController',
        'delete'
    ],
    '/posts/comment' => [
        'App\Controllers\CommentController',
        'create'
    ],
    '/admin' => [
        'App\Controllers\AdminController',
        'index'
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
];