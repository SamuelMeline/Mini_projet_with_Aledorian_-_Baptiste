<?php

namespace Libraries\MVC;

use Libraries\Database\Database;

abstract class AbstractModel
{
    protected Database $db;
    
    public function __construct()
    {
        $config = require 'config.php';
        $this->db = new Database($config);
    }
}