<?php

namespace App\Controllers;

use Libraries\MVC\AbstractController;
use App\Models\Event;
use App\Models\Comment;
use App\Models\Category;
use Libraries\Auth\User;
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

    public function create(): void
    {
        $user = new User();
        
        // if (! $user->isAuthenticated()) {
        //     $this->redirect('/login');
        // }
        
        if (empty($_POST)) {
            $model = new Category();
            $categories = $model->findAll();
            
            $this->render('events/create.phtml', [
                'categories' => $categories    
            ]);
        } else {
            $model = new Event();
            $model->create([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'picture' => $_POST['picture'],
                'started_at' => $_POST['date'],
                '1',
                'category_id' => $_POST['category'],
            ]);
            
            $this->redirect('/');
        }
    }

    public function edit(): void
    {
        $model = new Event;
        $event = $model->editEvent($_POST['title'], $_POST['description'], $_POST['picture'], $_POST['date']." ".$_POST['hour'], $_POST['id']);


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