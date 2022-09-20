<?php

namespace App\Models;

use Libraries\MVC\AbstractModel;

class UserModel extends AbstractModel
{
    public function findByName(string $username): ?array
    {
        return $this->db->getOne(
            'SELECT u.id, u.username, u.password
            FROM Users u
            WHERE u.username = ?', [
                $username    
            ]
        );
    }
    
    public function create(array $user): void
    {
        $this->db->execute(
            'INSERT INTO Users (username, password) VALUES (?, ?)', [
                $user['username'],
                $user['password']
            ]
        );
    }
}