<?php

use App\Controllers\HomeController;
use Boiler\Core\Engine\Router\Route;

/** 
 * Create routes here
 * ----------------------------
 * use Route::loadRoutes() to load other route files 
 * 
 * ---------------------------
 * 
 * Happy coding :) 
 * */

Route::get("/", [HomeController::class, "index"])->as("home");
