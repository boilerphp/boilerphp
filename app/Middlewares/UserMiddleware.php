<?php

namespace App\Middlewares;

use Boiler\Core\Middlewares\Middleware;


class UserMiddleware extends Middleware
{


    public function handle($request, $next)
    {
        if (!auth()) {
            return redirect('/auth-needed');
        }

        return $next;
    }
}
