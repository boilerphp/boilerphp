<?php

namespace Tests;

use Boiler\Core\Console\Console;
use Boiler\Core\Server;

trait Application
{

  function startApplication()
  {

    $console = new Console(server: new Server(), verbose: false);

    $console->command('migrate --fresh');
		$console->command('db seed');

  }
}
