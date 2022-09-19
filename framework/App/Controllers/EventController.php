<?php

namespace App\Controllers;

use Libraries\MVC\AbstractController;
use App\Models\Event;
use App\Models\Comment;
use App\Models\Category;
use Libraries\Http\NotFoundException;
use Libraries\Auth\User;

class EventController extends AbstractController
{
    public function show(): void
    {
        if (! isset($_GET['id'])) {
            throw new NotFoundException("Aucun article correspondant");
        }
        
        $model = new Event();
        $event = $model->find($_GET['id']);
        
        if ($event === null) {
            throw new NotFoundException("L'article n'existe pas");
        }
        
        $model = new Comment();
        $comments = $model->findByPost($_GET['id']);
        
        $this->render('events/show.phtml', [
            'event' => $event,
            'comments' => $comments
        ]);
    }
    
    public function create(): void
    {
        $user = new User();
        
        if (! $user->isAuthenticated()) {
            $this->redirect('/login');
        }
        
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
                'content' => $_POST['content'],
                'user_id' => $user->getId(),
                'category_id' => $_POST['category']
            ]);
            
            $this->redirect('/');
        }
    }
    
    public function edit(): void
    {
        $user = new User();
        
        if (! $user->isAuthenticated()) {
            $this->redirect('/login');    
        }
        
        $model = new Event();
        $event = $model->find($_GET['id']);
        
        if ($event === null) {
            throw new NotFoundException("L'article n'existe pas");
        }
        
        if (empty($_POST)) {
            $categoryModel = new Category();
            $categories = $categoryModel->findAll();
            
            $this->render('events/edit.phtml', [
                'event' => $event,
                'categories' => $categories
            ]);
        } else {
            $model->edit([
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'category_id' => $_POST['category'],
                'id' => $_POST['post_id']
            ]);
            
            $this->redirect('/admin');
        }
    }
    
    public function delete(): void
    {
        $user = new User();
        
        if (! $user->isAuthenticated()) {
            $this->redirect('/login');    
        }
        
        $model = new Event();
        $model->delete($_GET['id']);
        $this->redirect('/admin');
    }
}