<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
  use Application;

  protected function setUp(): void
  {
    $this->startApplication();
  }

  protected function tearDown(): void
  {
  }
}
