<?php

namespace App;

use Boiler\Core\Database\Model;


class RolePermissions extends Model {

    /**
    * defining all required fields 
    **/
    protected $required = [];


    public function permission() {

        return $this->hasOne(Permission::class, ["id" => "permission_id"]);
    }

    public function role() {

        return $this->hasOne(Role::class, ["id" => "role_id"]);
    }

}

?>