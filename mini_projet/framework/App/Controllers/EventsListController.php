<?php

namespace App\Controllers;

use Libraries\MVC\AbstractController;
use App\Models\Event;
use App\Models\Comment;
use App\Models\Category;
use Libraries\Auth\User;

use function PHPSTORM_META\type;

class EventsListController extends AbstractController
{

    public function index(): void
    {
        $model = new Event();
        $events = $model->findAll();

        $this->render("eventsList.phtml", [
            'events' => $events
        ]);
    }

    public function show(): void
    {
        $user = new User();

        $model = new Event();
        $showEvent = $model->find($_GET['id']);

        $model = new Comment();
        $comments = $model->findByPost($_GET['id']);


        $this->render('show_event.phtml', [
            'event' => $showEvent,
            'comments' => $comments,
            'user' => $user
        ]);
    }

    public function create(): void
    {
        $user = new User();

        if (!$user->isAuthenticated()) {
            $this->redirect('/login');
        }

        if (empty($_POST)) {
            $model = new Category();
            $categories = $model->findAll();

            $this->render('events/create.phtml', [
                'categories' => $categories
            ]);
        } else {

            if (!empty($_FILES)) {

                
                // 1 KO = 1024 octets
                // 1 MO = 1024 KO => 1MO = 1024 * 1024 octets
                $size = $_FILES['picture']['size'] / (1024 * 1024);
                
                // Si la taille est supérieure à 2MO
                if ($size > 2) {
                    // Gestion de l'erreur
                }
                
                if ($_FILES['picture']['error'] === UPLOAD_ERR_NO_FILE) {
                    // Erreur : pas de fichier à télécharger
                }
                
                $fileName = uniqid();
                
                $type = explode('/', $_FILES['picture']['type']);
                $extension = $type[1];
                $path = "App/img/$fileName.$extension";
                
                // Déplacer le fichier depuis son dossier temporaire vers le dossier img/
                move_uploaded_file($_FILES['picture']['tmp_name'], $path);
                
                // header('Location: index.php');
                // exit();

                $model = new Event();
                $model->create([
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'picture' => $path,
                    'position' => $_POST['position'],
                    'started_at' => $_POST['date'],
                    'user_id' => $user->getId(),
                    'category_id' => $_POST['category'],
                ]);

                $this->redirect('/');
            }
        }
    }

    public function edit(): void
    {
        $event = $model->editEvent($_POST['title'], $_POST['description'], $_POST['pictures'], $_POST['start'], $_POST['category'], $_POST['id']);

        $this->redirect("/");
    }

    public function editForm(): void
    {
        $user = new User;

        $model = new Event();
        $event = $model->find($_GET['id']);

        $model = new Category;
        $categories = $model->findAll();

        if ($user->getUsername() === 'admin' || $user->getId() === $event['user_id']) {

            $this->render('editForm.phtml', [
                'event' => $event,
                'categories' => $categories
            ]);
        } else {
            $this->redirect('/login');
        }
    }

    public function insertComment()
    {
        $user = new User;
        $model = new Comment();
        $comment = $model->create(
            [
                'content' => $_POST['content'],
                'event_id' => $_POST['event_id'],
                'user_id' => $user->getId()
            ]
        );


        $this->redirect("/event?id=" . $_POST['event_id']);
    }

    public function deleteComment(): void
    {
        $user = new User();

        if ($user->getUsername() === 'admin') {
            $model = new Comment();
            $model->delete($_GET['id']);
            $this->redirect('/admin');
        } else {
            $this->redirect('/login');
        }
    }

    public function comment(int $id)
    {
        $model = new Comment();
        $comments = $model->findx($_GET['id']);

        $this->render('show_event.phtml', [
            'comments' => $comments
        ]);
    }

    public function delete(): void
    {
        $user = new User();

        if ($user->getUsername() === 'admin') {
            $model = new Event();
            $model->delete($_GET['id']);
            $this->redirect('/admin');
        } else {
            $this->redirect('/login');
        }
    }

    public function registration(): void
    {
        $user = new User();

        if ($user->isAuthenticated()) {
            $model = new Event();
            $model->registration([
                'user_id' => $user->getId(),
                'event_id' => $_GET['id']
            ]);
            $this->redirect("/");
        }
    }
}
