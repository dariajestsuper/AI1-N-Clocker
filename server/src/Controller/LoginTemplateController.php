<?php

namespace App\Controller;

use Symfony\Component\Routing\RouteCollection;

class LoginTemplateController extends BaseTemplateController
{

    public function index(RouteCollection $routes)
    {
        require_once APP_ROOT . '/views/login.php';
    }
}
