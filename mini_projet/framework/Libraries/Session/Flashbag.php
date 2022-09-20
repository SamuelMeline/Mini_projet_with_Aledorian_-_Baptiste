<?php

namespace Libraries\Session;

class Flashbag
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function add(mixed $key, mixed $value): void
    {
        $_SESSION['errors'][$key] = $value;
    }
    
    public function has(mixed $key): bool
    {
        return isset($_SESSION['errors'][$key]);
    }
    
    public function hasErrors(): bool
    {
        return isset($_SESSION['errors']) && count($_SESSION['errors']) > 0;
    }
    
    public function get(mixed $key): mixed
    {
        if (! isset($_SESSION['errors'][$key])) {
            return null;
        }
        
        $message = $_SESSION['errors'][$key];
        unset($_SESSION['errors'][$key]);
        return $message;
    }
    
    public function all(): array
    {
        if (! isset($_SESSION['errors'])) {
            return [];
        }
        
        return $_SESSION['errors'];
    }
}