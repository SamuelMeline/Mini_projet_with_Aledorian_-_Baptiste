<?php

namespace App\Controllers;

use Libraries\MVC\AbstractController;
use App\Models\Event;

class EventsListController extends AbstractController{

    public function index() : void
    {
        $model = new Event();
        $events = $model->findAll();

        $this->render("eventsList.phtml", [
            'events' => $events
        ]);
    }

} 