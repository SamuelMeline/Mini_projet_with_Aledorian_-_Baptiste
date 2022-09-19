<?php

namespace App\Controllers;

use Libraries\MVC\AbstractController;

class ErrorController extends AbstractController
{
    public function show404(): void
    {
        http_response_code(404);
        $this->render('errors/404.phtml');
    }
}