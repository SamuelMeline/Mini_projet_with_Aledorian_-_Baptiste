<?php

namespace App\Controllers;

use Libraries\MVC\AbstractController;
use App\Models\Event;

class AdminController extends AbstractController
{
    public function index(): void
    {
        // Récupérer la liste des articles
        $model = new Event();
        $events = $model->findAll();
        
        // Afficher le template
        $this->render('admin.phtml', [
            'events' => $events  
        ]);
    }
}