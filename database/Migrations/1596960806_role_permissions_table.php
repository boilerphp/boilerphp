<?php

use Boiler\Core\Database\Migration\Diagram;
use Boiler\Core\Database\Migration\Migration;
use Boiler\Core\Database\Migration\Table;

class RolePermissionsTable extends Migration
{

    /**
     * creates database table
     * 
     * @return void
     */
    public function in()
    {

        Table::create("role_permissions", function (Diagram $diagram) {

            $diagram->id();
            $diagram->column("role_id")->bigInteger();
            $diagram->column("permission_id")->bigInteger();
            $diagram->column("created_by")->bigInteger();
            $diagram->column("updated_by")->bigInteger();
            $diagram->timestamps();
        });
    }

    /**
     * drop database table
     * 
     * @return void
     */
    public function out()
    {
        Table::dropIfExists("role_permissions");
    }
}
