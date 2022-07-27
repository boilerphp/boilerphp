<?php

namespace App\Controllers;


use Boiler\Core\Actions\Urls\Controller;
use Boiler\Core\Engine\Router\Request;
use Boiler\Core\Engine\Router\Response;


class BaseController extends Controller
{

    public function index()
    {

        return Response::view("index");
    }
}
