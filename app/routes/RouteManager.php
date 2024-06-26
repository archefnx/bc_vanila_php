<?php

namespace App\Routes;

use App\Controllers\ProccessController;
use App\Controllers\FieldController;
use App\Controllers\TypeController;
use App\Controllers\ProccessManageController;
use App\Core\Router;

class RouteManager
{
    public function run()
    {
        $router = new Router();
        require 'api.php';
        echo $router->resolve($_SERVER['REQUEST_URI']);
    }
}