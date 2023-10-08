<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Boiler\Core\Engine\Router\Request;
use Boiler\Core\Engine\Router\Response;


class HomeController extends Controller
{

    public function index()
    {
        return $this->render("index");
    }

    public function about()
    {
        return $this->render('about');
    }
}
