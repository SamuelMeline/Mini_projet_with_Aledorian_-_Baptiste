<?php

namespace App\Models;

use Libraries\MVC\AbstractModel;

class CategoryModel extends AbstractModel
{
    public function findAll(): array
    {
        return $this->db->getAll(
            'SELECT c.id, c.name
            FROM categories c
            ORDER BY c.name'  
        );
    }
}