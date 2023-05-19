<?php

use App\Controllers\BaseController;
use App\Middlewares\UserMiddleware;
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


Route::middleware([UserMiddleware::class], function() {
    Route::get("/", [BaseController::class, "index"])->as("home");
});
