<?php

namespace App\Controllers;

use Libraries\MVC\AbstractController;
use App\Models\Event;
use App\Models\Comment;

class AdminController extends AbstractController
{
    public function index(): void
    {
        // Récupérer la liste des articles
        $model = new Event();
        $events = $model->findAll();

        $model = new Comment();
        $comments = $model->findAll();
        
        // Afficher le template
        $this->render('admin.phtml', [
            'events' => $events,
            'comments' => $comments  
        ]);
    }
}