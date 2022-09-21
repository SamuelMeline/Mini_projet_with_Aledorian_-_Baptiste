<?php

namespace App\Controllers;

use Libraries\MVC\AbstractController;
use App\Models\UserModel;
use Libraries\Auth\User;
use Libraries\Session\Flashbag;

class UserController extends AbstractController
{
    public function register(): void
    {
        if (empty($_POST)) {
            $this->render('users/register.phtml');
        } else {
            $model = new UserModel();
            $user = $model->findByName($_POST['username']);
            
            $flashbag = new Flashbag();
            
            if ($user !== null) {
                $flashbag->add('username', "Le nom d'utilisateur existe déjà");
            }
            
            if ($flashbag->hasErrors()) {
                $this->redirect('/register');
            }
            
            $model->create([
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_ARGON2ID)
            ]);
            
            $this->redirect('/login');
        }
    }
    
    public function login(): void
    {
        if (empty($_POST)) {
            $this->render('users/login.phtml');
        } else {
            $model = new UserModel();
            $user = $model->findByName($_POST['username']);
            
            $flashbag = new Flashbag();
            
            if ($user === null) {
                $flashbag->add('username', "Les identifiants sont incorrects");
                $this->redirect('/login');
            }
            
            if (! password_verify($_POST['password'], $user['password'])) {
                $flashbag->add('username', "Les identifiants sont incorrects");
                $this->redirect('/login');
            }
            
            $session = new User();
            $session->login($user['id'], $user['username']);
            
            $this->redirect('');
        }
    }
        
    public function logout(): void
    {
        $user = new User();
        $user->logout();
        $this->redirect('');
    }
}