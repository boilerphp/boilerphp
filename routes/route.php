<?php

use App\Controllers\BaseController;
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

Route::get("/", [BaseController::class, "index"])->as("home");
