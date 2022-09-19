<?php

namespace App\Controllers;

use Libraries\MVC\AbstractController;
use App\Models\Event;
use App\Models\Category;

class EventsListController extends AbstractController{

    public function index() : void
    {
        $model = new Event();
        $events = $model->findAll();

        $this->render("eventsList.phtml", [
            'events' => $events
        ]);
    }

    public function show(): void
    {
        $model = new Event();
        $showEvent = $model->find($_GET['id']);

        $this->render('show_event.phtml',[
            'event' => $showEvent
        ]);
    }

    public function edit(): void
    {
        $model = new Event;

        $event = $model->editEvent($_POST['title'], $_POST['description'], $_POST['pictures'], $_POST['date']." ".$_POST['hour'], $_POST['id']);


        $this->redirect("/");
    }

    public function editForm() : void
    {
        $model = new Event();
        $event = $model->find($_GET['id']);

        $model = new Category;
        $categories = $model->findAll();

        $this->render('editForm.phtml', [
            'event' => $event,
            'categories' => $categories
        ]);
    }
} 