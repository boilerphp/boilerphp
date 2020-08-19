<?php 

use App\Core\Database\Migration;

class RoleTable extends Migration {

    /**
     * creates database table
     * 
     * @return void
     */
    public function create() {

        $this->table("roles");
        $this->field("id")->bigIncrements()->null();
        $this->field("name")->string()->unique();
        $this->field("created_date")->timestamp();
        $this->field("updated_date")->timestamp();
        $this->field("created_by")->integer();
        $this->field("updated_by")->integer();

        $this->sign();
    }

    /**
     * drop database table
     * 
     * @return void
     */
    public function drop() {

        $this->dropIfExists("roles");
    }

}

