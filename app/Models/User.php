<?php

namespace App\Models;

use Boiler\Core\Admin\Traits\HasAccessTokens;
use Boiler\Core\Database\Model;


class User extends Model {

    use HasAccessTokens;

    /**
    * defining all required fields 
    **/
    protected $required = [];

    
    public function role()
    {
        return $this->hasOne(Role::class, ["id" => "role_id"]);
    }

}

?>