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
}