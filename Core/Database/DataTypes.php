<?php

namespace App\Core\Database;


class DataTypes {

    public $query;

    public $primary_keys;

    public $nullable = "NOT NULL";

    public function trimmer($str) 
    {
        return trim($str, ",");
    }

    public function bigIncrements() 
    {
        $this->primary_keys .= " `$this->column`,";
        $this->query .= " `$this->column` INT(16) AUTO_INCREMENT,";
        return $this;
    }

    public function boolean() 
    {
        $this->query .= " `$this->column` TINYINT(1),";
        return $this;
    }

    public function date() 
    {
        $this->query .= " `$this->column` DATE DEFAULT CURRENT_TIMESTAMP(),";
    }

    public function float($length = 10, $decimal = 2) 
    {
        $this->query .= " `$this->column` FLOAT(". (string) $length.", ". (string) $decimal."),";
        return $this;
    }

    public function increments() 
    {
        $this->primary_keys .= " `$this->column`,";
        $this->query .= " `$this->column` INT(9) AUTO_INCREMENT,";
        return $this;
    }

    public function id($type = "int", $length = 6) 
    {

        switch($type) {
            case "int": 
                $this->query .= " `$this->column` INT(". (string) $length .") UNIQUE,";
            break;
            case "string":
                $this->query .= " `$this->column` VARCHAR(". (string) $length .") UNIQUE,";
            break;
        }

        return $this;
    }

    public function int($length = 9) 
    {
        $this->query .= " `$this->column` INT(". (string) $length ."),";
        return $this;
    }

    public function integer($length = 9) 
    {
        $this->query .= " `$this->column` INT(". (string) $length ."),";
        return $this;
    }

    public function string($length = 100) 
    {
        $this->query .= " `$this->column` VARCHAR(". (string) $length ."),";
        return $this;
    }

    public function text() 
    {
        $this->query .= " `$this->column` TEXT,";
        return $this;
    }

    public function longtext() 
    {
        $this->query .= " `$this->column` LONGTEXT,";
        return $this;
    }

    public function null() 
    {

        $this->query = $this->trimmer($this->query);
        $this->query .= " DEFAULT NULL,";
        return $this;
    }

    public function time() 
    {
        $this->query .= " `$this->column` TIME DEFAULT CURRENT_TIMESTAMP(),";
    }

    public function timestamp() 
    {
        $this->query .= " `$this->column` DATETIME DEFAULT CURRENT_TIMESTAMP(),";
    }

    public function unique() 
    {
        $this->query = $this->trimmer($this->query);
        $this->query .= " UNIQUE,";
        return $this;
    }


}