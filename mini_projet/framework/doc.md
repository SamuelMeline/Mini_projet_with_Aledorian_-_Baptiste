# Documentation

## Arborescence

index.php
config.php
helpers.php
routes.php
App/
    Models/
    Controllers/
    Views/
Libraries/
    Database/
        Database.php
    MVC/
        AbstractController.php
        AbstractModel.php

## Création d'une page

Pour créer une nouvelle page, il faudra toujours suivre la même procédure :
1. Créer une route dans le fichier *routes.php*
2. Cette route contiendra l'url de la page, le nom du contrôleur et la méthode à appeler
3. Créer le contrôleur si il n'existe pas déjà
4. Créer la méthode dans ce contrôleur
5. Dans la méthode du contrôleur, récupérer si besoin des données de la base de données à l'aide d'un modèle ou ajouter/modifier/supprimer des données
6. Afficher le template de la page / Rediriger vers une autre page

## Routing

```php
// Exemple de quelques routes
return [
    '/' => [
        'App\Controllers\HomeController',
        'index'
    ],
    '/customers' => [
        'App\Controllers\CustomerController',
        'index'
    ],
    '/customers/show' => [
        'App\Controllers\CustomerController',
        'show'
    ],
    '/customers/create' => [
        'App\Controllers\CustomerController',
        'create'
    ]
];
```

## Contrôleur

Les contrôleurs sont à créer dans le dossier "App/Controllers" et devront avoir comme namespace "App\Controllers". Tous les contrôleurs hériteront du contrôleur du framework, la classe *AbstractController*. Les contrôleurs contiendront 2 méthodes : 

* render : affiche une vue
* redirect : rediriger vers l'url d'une route

### Utilisation

```php
// Exemple d'un contrôleur

namespace App\Controllers;

use Libraries\MVC\AbstractController;
use App\Models\CustomerModel;

class CustomerController extends AbstractController
{
    public function index(): void
    {
        $model = new CustomerModel();
        $customers = $model->all();
        
        $this->render('customer_list.phtml', [
            'customers' => $customers
        ]);
    }
    
    public function show(): void
    {
        $model = new CustomerModel();
        $customer = $model->find($_GET['id']);
        
        $this->render('customer_detail.phtml', [
            'customer' => $customer
        ]);
    }
    
    public function create(): void
    {
        $model = new CustomerModel();
        $model->create($_POST);
        
        $this->redirect('/customers');
    }
}
```

## Modèle

Tous les modèles sont à créer dans le dossier "App/Models" et auront comme namespace "App\Models". Tous les modèles doivent hériter de la classe modèle du framework, *AbstractModel*. Les modèles contiennent une propriété *db* qui est une instance de *Database*.

### Utilisation

```php
namespace App\Models;

use Libraries\MVC\AbstractModel;

class CustomerModel extends AbstractModel
{
    public function all(): array
    {
        return $this->db->getAll(
            'SELECT customerNumber, customerName, addressLine1, postalCode, country, city
            FROM customers
            ORDER BY customerName'
        );
    }
}
```

## Vue

Les vues sont des fichiers *.phtml* qui vont contenir principalement du html avec un peu de php. Ils doivent être créés dans le dossier "App/Views".

**NB :** Si vous voulez passer des données depuis le contrôleur vers la vue, il faut bien penser à mettre ces données dans le 2ème paramètre de la méthode *render* du contrôleur.

**NB2 :** Pour la navigation des pages, dans les attributs href de vos liens, utiliser la fonction *url* pour afficher correctement le lien.

```php
<a href="<?= url('customer_list') ?>">Tous les clients</a>
```

## Classe Database

La classe *Database* est une surcouche de la bibliothèque PHP *PDO*. Elle contient 3 méthodes : 

* *getAll* qui récupère tous les résultats d'une requête SELECT
* *getOne* qui récupère le premier résultat d'une requête SELECT
* *execute* qui exécute une requête INSERT, UPDATE ou DELETE

### Configuration

Configurer les informations de connexion à la base de données dans le fichier *config.php*.

### Utilisation

```php
$db = new Database();
$results1 = $db->getAll('SELECT ... FROM ...');

$results2 = $db->getAll('SELECT ... FROM ... WHERE champ1 = ? OR champ2 = ?', [
    'valeur1', 
    'valeur2'
]);

$results3 = $db->getOne('SELECT ... FROM ... WHERE id = ?', [
    'valeur id'
]);

$db->execute('INSERT INTO table(champ1, champ2) VALUES (?, ?)', [
    'valeur1', 'valeur2'
]);
```