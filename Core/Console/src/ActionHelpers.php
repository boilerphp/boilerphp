<?php 

namespace Console\Support;

use App\Core\Database\Schema;
use Console\Support\Interfaces\ActionHelpersInterface;



class ActionHelpers implements ActionHelpersInterface {

    public $commands = array(
        "create", "start", "db"
    );

    public $flags = array(
        "--m" => "model",
        "--a" => "all",
        "--c" => "controller",
        "--d" => "migration"
    );

    public $configurations = array(
        "model" => "configiureModel",
        "controller" => "configureController",
        "migration" => "configureMigration",
        "notification" => "configureNotification"
    );

    public $paths = array(
        "model" => "./Models/",
        "controller" => "./Controllers/",
        "migration" => "./Migrations/",
        "notification" => "./Notification/",
    );

    /**
     * checks flag and action
     * for difference
     * @return bool
     */

    public function flagchecker($action, $flag) 
    {
        
        if($this->flags[$flag] == $action) {
            echo "mis-usage of flag on create ". $action;
            return false;
        }

        return true;
    }

    public function flagHandler($name, $flag, $action) 
    {

        if($flag == "--a") {
            foreach($this->flags as $flag => $task) {
                if($task == $action || $task == "all") {
                    continue;
                }

                $this->flagConfig($flag, $name);
            }
        } else {
            $this->flagConfig($flag, $name);
        }

    }

    public function flagConfig($flag, $name) 
    {
        $task = $this->flags[$flag];

        if($task == "controller") { $name .= "Controller"; }

        $path = $this->paths[$task].$name.".php";
        $configuration = $this->configurations[$task];
        $this->$configuration($name, $path);

    }

    public function checkExistent($path) {

        if(file_exists($path)){ return true;}
        return false;
    }


    public function checkMigrationExistent($filename) {

        $all_migrations_file = glob("./Migrations/*.php");
        if($all_migrations_file) {
            foreach($all_migrations_file as $migration_file){
                if($this->migrationFileNameChecker($migration_file, $filename)){
                    return true;
                }
            }
        }
        return false;
    }


    public function migrationFileNameChecker($migration_file, $name_format)
    {
        $ex = explode("/", $migration_file);
        $exMfile = explode("_",$ex[2]);
        $filename = $exMfile[1]."_".$exMfile[2];

        if($filename == $name_format) {
            return true;
        }

        return false;
    }

    /**
     * usage: configures model structure and inital setup
     * @param string model_name
     * @param string model_path
     * 
     * @return void;
     */

    public function configureModel($model_name, $model_path) 
    {
        $component_path = "./Core/Console/lib/components/model.component";

        if($this->readComponent($component_path)) {
            $this->module = preg_replace("/\[Model\]/",$model_name, $this->component);
            if($this->writeModule($model_path)) {
                echo "Model $model_name successfully created!\n";
                return true;
            }
            return false;
        }
    }

    
    /**
     * usage: configures migration structure and inital setup
     * @param string migration_name
     * @param string migration_path
     */
    public function configureMigration($migration_name, $migration_path) 
    {
        $component_path = "./Core/Console/lib/components/migration.component";
        if($this->readComponent($component_path)) {
            $this->module = preg_replace("/\[ClassName\]/",$migration_name."Table", $this->component);
            $this->module = preg_replace("/\[TableName\]/", strtolower($migration_name."s"), $this->module);

            if($this->writeModule($migration_path)) {
                echo "Migration $migration_name successfully created!\n";
                return true;
            }
            return false;
        }
    }


    /**
     * usage: configures controller structure and inital setup
     * @param string controller_name
     */
    public function configureController($controller_name, $controller_path) 
    {
        $component_path = "./Core/Console/lib/components/controller.component";

        if($this->readComponent($component_path) !== "") {

            $this->module = preg_replace("/\[Controller\]/", $controller_name, $this->component);
            $view_folder = str_replace("controller", "", strtolower($controller_name));

            if(!$this->checkExistent("./Views/".$view_folder)) {
                mkdir("./Views/".$view_folder);
            }
    
            $this->module = preg_replace("/\[View\]/", $view_folder, $this->module);
            if($this->writeModule($controller_path)) {
                echo "$controller_name successfully created!\n";
                return true;
            }
            return false;
        }

    }


    /**
     * checks and returns command length
     * @param command 
     * @return int
     */
    public function getCommandLength(array $command)
    {
        return count($command);
    }


    /**
     * reads the component file and get the components structure
     * @param string component_file_path
     * @return string
     */
    public function readComponent($path)
    {
        $this->component = file_get_contents($path); return $this->component;
    }



    public function writeModule($path)
    {
        $module = fopen($path, "w"); fwrite($module, $this->module); return fclose($module);
    }


    public function checkTableExists($table)
    {
        $schema = new Schema;
        $checking = $schema->query("SHOW TABLES");
        $tables = $checking->fetchAll();
        if($tables) {
            foreach($tables as $key => $value) {
                if($value["Tables_in_".$schema->getDbName()] == $table) {
                    return true;
                }
            }
        }
        return false;
    }

    public function newMigrationsChecker()
    {
        $this->new_migrations = array();
        $all_migrations_file = glob("./Migrations/*.php");
        
        if($all_migrations_file) {
            if($this->checkTableExists("migrations")) {
                foreach($all_migrations_file as $migration_file){
                    if($this->migrationWaitingMigrate($migration_file)) {
                        array_push($this->new_migrations, $migration_file);
                    }
                }
            }
            else {
                $this->new_migrations = $all_migrations_file;
            }
        } 

        if(count($this->new_migrations) > 0){
            return true;
        }

        return false;
    }


    public function migrationWaitingMigrate($migration_file)
    {
        $ex = explode("/", $migration_file);
        $migration = str_replace(".php", "", $ex[2]);

        if($this->isWaiting($migration)){
            return true;
        }

        return false;
    }

    public function isWaiting($migration) 
    {
        $schema = new Schema;
        $schema->table = "migrations";
        $checking = $schema->select("migration", $migration);

        if($checking) {
            return false;
        }
        return true;
    }

    public function createMigrationsTable() {
        
        $schema = new Schema;
        return $create_table = $schema->query("CREATE TABLE IF NOT EXISTS migrations(
            `id` INT(9) NOT NULL AUTO_INCREMENT,
            `migration` VARCHAR(255) DEFAULT NULL,
            `version` INT(9) DEFAULT NULL,
            `created_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY(`id`)
            )
        ");

    }

    public function runMigrations()
    {
        foreach($this->new_migrations as $migration) {
            $this->requireOnce($migration);
            echo "Creating ".$this->mFileFormater($migration)["table"]." table: ".$this->mFileFormater($migration)["file"]."\n";
            $this->migrationClass($migration)->create();
            $this->registerMigration($this->mFileFormater($migration)["file"], 1);
            echo "Created ".$this->mFileFormater($migration)["table"]." table: ".$this->mFileFormater($migration)["file"]."\n";
        }
    }

    public function registerMigration($file, $version) 
    {
        $schema = new Schema;
        $schema->table = "migrations";
        $schema->insert(["migration" => $file, "version" => $version]);
    }

    public function requireOnce($filepath)
    {
        return require_once $filepath;
    }

    public function migrationClass($migration)
    {
        $class = $this->mFileFormater($migration)["class"];
        return new $class;
    }

    public function mFileFormater($migration) 
    {
        $split = explode("/", $migration);
        $ex = str_replace(".php", "", $split[2]);

        $exMfile = explode("_", $ex);

        $classname = ucfirst($exMfile[1]).ucfirst($exMfile[2]);
        $filename = $ex;

        $tablename = ucfirst($exMfile[1]."s");

        return array("class" => $classname, "file" => $filename, "table" => $tablename);
    }
}