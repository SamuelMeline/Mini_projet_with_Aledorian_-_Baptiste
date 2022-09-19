<?php

namespace App\Models;

use Libraries\MVC\AbstractModel;

class User extends AbstractModel
{
    public function findByName(string $username): ?array
    {
        return $this->db->getOne(
            'SELECT u.id, u.username, u.created_at, u.password
            FROM users u
            WHERE u.username = ?', [
                $username    
            ]
        );
    }
    
    public function create(array $user): void
    {
        $this->db->execute(
            'INSERT INTO users (username, password, created_at) VALUES (?, ?, NOW())', [
                $user['username'],
                $user['password']
            ]
        );
    }
}