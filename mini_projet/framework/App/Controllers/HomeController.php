<?php

namespace App\Controllers;

use App\Models\Comment;
use Libraries\MVC\AbstractController;
use App\Models\Event;


class HomeController extends AbstractController
{
    public function index(): void
    {
        // Récupérer la liste des articles
        $model = new Event();
        $events = $model->findx(5);
        $hiddenEvents = $model->findAll();

        $model = new Comment();
        $comments = $model->findx(5);

        // Afficher le template
        $this->render('Home.phtml', [
            'events' => $events,
            'hiddenEvents' => $hiddenEvents,
            'comments' => $comments
        ]);
    }
}