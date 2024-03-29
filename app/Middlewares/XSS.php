<?php

namespace App\Middlewares;

use Boiler\Core\Engine\Router\Request;
use Boiler\Core\Middlewares\Middleware;

class XSS extends Middleware 
{

    /**
     * runs on route request
     * 
     * @param \Boiler\Core\Engine\Router\Request $request
     * @param $next
     *
     * @return \Boiler\Core\Engine\Router\Request $request|$next
     */
    public function handle(Request $request, $next) 
    {
        //...
        
        return $next;
    }

}

?>