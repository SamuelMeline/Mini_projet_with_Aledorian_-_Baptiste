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
            'events' => $events,
        ]);
    }

    public function show(): void
    {
        $user = new User();

        $model = new Event();
        $showEvent = $model->find($_GET['id']);

        $model = new Comment();
        $comments = $model->findByPost($_GET['id']);

        $pos = $showEvent['position'];

        $pos = explode(" ",$pos);

        // var_dump($pos);  

        $results = json_decode(file_get_contents('https://api-adresse.data.gouv.fr/reverse/?lon='.$pos[0].'&lat='.$pos[1]), true);
        
        $address = $results["features"][0]["properties"]['label'];

        $this->render('show_event.phtml', [
            'event' => $showEvent,
            'comments' => $comments,
            'user' => $user,
            'address' => $address
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

            // ON RECUPERE LA POSITION VIA L'INPUT

            $position = urlencode($_POST['position']);

            // FAIT LA REQUETE VERS L'API

            $results = json_decode(file_get_contents('https://api-adresse.data.gouv.fr/search/?q='.$position), true);

            // ON STOCK LES COORDONNEES DANS DES VARIABLES

            $longitude = $results["features"][0]["geometry"]["coordinates"][0]; 
            $latitude = $results["features"][0]["geometry"]["coordinates"][1];

            $position = $longitude . " " . $latitude;

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

                $model = new Event();
                $model->create([
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'picture' => $path,
                    'position' => $position,
                    'started_at' => $_POST['date'],
                    'user_id' => $user->getId(),
                    'category_id' => $_POST['category'],
                ]);

                $this->redirect('');
            }
        }
    }

    public function edit(): void
    {

        $model = new Event();
        
        $model->editEvent($_POST['title'], $_POST['description'],$_POST['position'], $_POST['date'], $_POST['category'], $_POST['id']);

        $this->redirect("");
    }

    public function editForm(): void
    {
        $user = new User;

        $model = new Event();
        $event = $model->find($_GET['id']);

        $model = new Category;
        $categories = $model->findAll();

        if(! isset($event)){
            $this->render('errors/404.phtml');
        }else{
            if ($user->getUsername() === 'admin' || $user->getId() === $event['user_id']) {
    
                $this->render('editForm.phtml', [
                    'event' => $event,
                    'categories' => $categories
                ]);
            } else {
                $this->redirect('/login');
            }
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
        else{
            $this->redirect("/login");
        }
    }

    public function distance(): void
    {
        function getDistanceBetweenPointsNew(float $latitude1, float $longitude1, float $latitude2, float $longitude2, $unit = 'miles') :float 
        {

            $earth_radius = 6372.795477598;

            $delta_lat = $latitude2 - $latitude1 ;
            $delta_lon = $longitude2 - $longitude1 ;

            $a = pow(sin(deg2rad($delta_lat/2)), 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * pow(sin(deg2rad($delta_lon/2)), 2);
            
            $c = 2 * asin(sqrt($a));

            $distance = $earth_radius * $c;

            return (round($distance, 4));
        }

        // récupére tout les events

        $model = new Event();
        $AllEvents = $model->findAll();

        // var_dump($_POST);

        foreach($AllEvents as $event)
        {
            // separe Longitude et Latitude de chaque events
            $position = explode(" ", $event['position']);


            // calcul la distance entre ma position et celle des evenement en km

            $distance = getDistanceBetweenPointsNew(floatval($_POST['lat']), floatval($_POST['long']), floatval($position[1]), floatval($position[0]), $unit = 'kilometers');

            if($distance < 50){
                $events[] = $event;
            }
        }

        if(isset($events))
        {
            $this->render("eventsProxi.phtml",[
                "events" => $events
            ]);
        }
        else{
            $events = [];
            $this->render("eventsProxi.phtml",[
                "events" => $events
            ]);
        }
    }
}
