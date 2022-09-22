<?php

namespace App\Models;

use Libraries\MVC\AbstractModel;

class Event extends AbstractModel{

    public function findAll() : array 
    {
    
        return $this->db->getAll(
            'SELECT e.id, e.title, e.created_at, e.description, e.pictures, e.started_at, e.user_id, u.username, c.name, e.position
            FROM Events e
            INNER JOIN Users u ON e.user_id = u.id
            INNER JOIN Categories c ON e.category_id = c.id'
        );
    }

    public function find(int $id): ? array
    {
        return $this->db->getOne(

            'SELECT e.user_id, e.title,e.id, e.description, e.pictures, e.created_at, e.started_at, e.category_id, u.username, c.name, e.position
            FROM Events e
            INNER JOIN Users u ON e.user_id = u.id
            INNER JOIN Categories c ON e.category_id = c.id
            WHERE e.id = ?', [$id]
        );
    }

    public function editEvent($title, $description,$position, $start, $category, $id) :void
    {
        $this->db->execute(
            "UPDATE Events SET title = ?, description = ?, position = ?, started_at = ?, category_id = ? WHERE id = ?
            ",
            [$title, $description, $position, $start, $category, $id]
        );
    }
    
    public function findx(int $id): ? array
    {
        return $this->db->getAll(
            'SELECT e.title, e.description, e.pictures, e.created_at, e.started_at, u.username, c.name, e.id, e.position
            FROM Events e
            INNER JOIN Users u ON e.user_id = u.id
            INNER JOIN Categories c ON e.category_id = c.id
            ORDER BY created_at DESC
            limit 5'
        );
    }

    public function create(array $event): void
    {
        $this->db->execute(
            'INSERT INTO Events (title, description, pictures, position, started_at, user_id, category_id) VALUES (?, ?, ?, ?, ?, ?, ?)', [
                $event['title'],
                $event['description'],
                $event['picture'],
                $event['position'],
                $event['started_at'],
                $event['user_id'],
                $event['category_id']
            ]  
        );
    }

    public function delete(int $id): void
    {
        $this->db->execute(
            'DELETE FROM Events WHERE id = ?', [$id]
        );
    }

    public function registration(array $data) : void
    {
        $this->db->execute(
            'INSERT INTO Registration (user_id, event_id) VALUES (?, ?)',[
                $data['user_id'],
                $data['event_id']
            ]
        );
    }
}
