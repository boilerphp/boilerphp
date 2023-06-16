<?php

namespace Tests\Integration;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

  public function testUserAccountCreation()
  {
    $user = (new User)->create(['firstname' => 'John']);
    $this->assertNotEmpty($user->firstname);
  }
}
