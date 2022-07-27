<?php

namespace Tests;

use Boiler\Core\Console\Console;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
	
	use Application;

	public function __construct()
  {
    parent::__construct("Testing");

    $this->startApplication();
  }
}
