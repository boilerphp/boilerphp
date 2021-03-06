<?php

namespace App\Models;

use Boiler\Core\Database\Model;


class Permission extends Model {

    /**
    * defining all required fields 
    **/
    protected $required = [];


    public function creator() {
        return $this->hasOne(User::class, ["id" => "created_by"]);
    }

    public function updator() {
        return $this->hasOne(User::class, ["id" => "updated_by"]);
    }

}

?>