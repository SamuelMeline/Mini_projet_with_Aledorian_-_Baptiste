<?php

require 'config.php';
require 'models/Event.php';
require 'models/Comment.php';

if (empty($_POST)) {
    // Formulaire non envoyé => affichage de l'article
    
    // Récupération de l'article
    $event = getEventDetail($_GET['id']);
    
    // Si l'article n'existe pas
    if ($event === false) {
        http_response_code(404);
        $template = '404.phtml';
        require 'views/layout.phtml';
        exit();
    }
    
    // Récupération de tous les commentaires de l'article
    $comments = getEventComments($_GET['id']);
    
    // Affichage du template
    $template = 'show_event.phtml';
    require 'views/layout.phtml';
} else {
    // Formulaire envoyé => enregistrement du commentaire en base de données
    createComment([
        'nickname' => $_POST['nickname'],
        'content' => $_POST['content'],
        'event_id' => $_POST['event_id']
    ]);
    
    // Rediriger vers la page de l'article
    header('Location: show_event.php?id=' . $_POST['event_id']);
    exit();
}