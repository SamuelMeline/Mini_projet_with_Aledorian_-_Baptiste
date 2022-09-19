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

    public function find(int $id): ?array
    {
        return $this->db->getOne(
            'SELECT e.title, e.description, e.pictures, e.created_at, e.started_at, e.category_id, u.username, c.name
            FROM Events e
            INNER JOIN Users u ON e.user_id = u.id
            INNER JOIN Categories c ON e.category_id = c.id
            WHERE e.id = ?', [$id]
        );
    }

    public function editEvent($title, $description, $pictures, $start, $category, $id) :void
    {
        $this->db->execute(
            "UPDATE Events SET title = ?, description = ?, pictures = ?, started_at = ?, category_id = ? WHERE id = ?
            ",
            [$title, $description, $pictures, $start, $category, $id]
        );
    }
    
}

