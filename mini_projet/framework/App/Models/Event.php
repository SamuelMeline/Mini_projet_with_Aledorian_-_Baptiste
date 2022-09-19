<?php

namespace App\Models;

use Libraries\MVC\AbstractModel;

class Event extends AbstractModel{

    public function findAll() : array 
    {
    
        return $this->db->getAll(
            'SELECT e.title, e.created_at, e.description, e.pictures, e.started_at, e.user_id, u.username
            FROM Events e
            INNER JOIN Users u ON e.user_id = u.id'
        );
    }
    
    public function find(int $id): ?array
    {
        return $this->db->getOne(
            'SELECT e.title, e.description, e.pictures, e.created_at, e.started_at
            FROM Events e
            INNER JOIN users u ON e.user_id = u.id
            INNER JOIN categories c ON e.category_id = c.id
            WHERE Events.id = ?', [$id]
        );
    }
}