<?php 

use Boiler\Core\Database\Migration\Diagram;
use Boiler\Core\Database\Migration\Migration;
use Boiler\Core\Database\Migration\Table;

class PermissionTable extends Migration {

    /**
     * creates database table
     * 
     * @return void
     */
    public function in() {

        Table::create("permissions", function(Diagram $diagram) {

            $diagram->id();
            $diagram->column("name")->string()->unique();
            $diagram->column("created_by")->bigInteger()->foreign("users", "id");
            $diagram->column("updated_by")->bigInteger()->foreign("users", "id");
            $diagram->timestamps();

        });
    }

    /**
     * drop database table
     * 
     * @return void
     */
    public function out() {

        Table::dropIfExists("permissions");
    }

}

