<?php

namespace App\Models;

use Libraries\MVC\AbstractModel;

class Event extends AbstractModel{

    public function findAll() : array 
    {
    
        return $this->db->getAll(
            'SELECT e.id, e.title, e.created_at, e.description, e.pictures, e.started_at, e.user_id, u.username, c.name
            FROM Events e
            INNER JOIN Users u ON e.user_id = u.id
            INNER JOIN Categories c ON e.category_id = c.id'
        );
    }

    public function find(int $id): ? array
    {
        return $this->db->getOne(
            'SELECT e.title, e.description, e.pictures, e.created_at, e.started_at, u.username, c.name
            FROM Events e
            INNER JOIN Users u ON e.user_id = u.id
            INNER JOIN Categories c ON e.category_id = c.id
            WHERE e.id = ?', [$id]
        );
    }

    public function findx(int $id): ? array
    {
        return $this->db->getAll(
            'SELECT e.title, e.description, e.pictures, e.created_at, e.started_at, u.username, c.name, e.id
            FROM Events e
            INNER JOIN Users u ON e.user_id = u.id
            INNER JOIN Categories c ON e.category_id = c.id
            limit 5'
        );
    }

    public function create(array $event): void
    {
        $this->db->execute(
            'INSERT INTO Events (title, description, pictures, started_at, user_id, category_id) VALUES (?, ?, ?, ?, ?, ?)', [
                $event['title'],
                $event['description'],
                $event['pictures'],
                $event['started_at'],
                1,
                $event['category_id']
            ]  
        );
    }
}
