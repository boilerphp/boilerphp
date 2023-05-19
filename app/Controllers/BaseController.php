<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Boiler\Core\Engine\Router\Request;
use Boiler\Core\Engine\Router\Response;


class BaseController extends Controller
{

    public function index()
    {
        return Response::view("index");
    }
}
