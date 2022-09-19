<?php

namespace Libraries\Auth;

class User
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function isAuthenticated(): bool
    {
        return isset($_SESSION['auth']);
    }
    
    public function login(int $id, string $username): void
    {
        $_SESSION['auth'] = [
            'id' => $id,
            'username' => $username
        ];
    }
    
    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }
    
    public function getId(): ?int
    {
        if ($this->authenticated()) {
            return $_SESSION['auth']['id'];
        } else {
            return null;
        }
    }
    
    public function getUsername(): ?string
    {
        if ($this->isAuthenticated()) {
            return $_SESSION['auth']['username'];
        } else {
            return null;
        }
    }
}