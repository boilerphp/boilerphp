<?php

namespace App;

use Boiler\Core\Database\Model;


class PasswordReset extends Model {

    /**
    * defining all required fields 
    **/
    protected $required = [];


    public $table = "password_resets";


}

?>