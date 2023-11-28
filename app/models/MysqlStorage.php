<?php

namespace App\Models;

class MysqlStorage implements Storage{

    private static \mysqli $connection;

    private static Storage $instance;

    private function __construct()
    {
        //self::$connection = null;
    }

    public function getDataTitles($tableName){
        $columns = self::$connection->query("SHOW COLUMNS FROM `".$tableName."`");
        return $columns;
    }

    public function getData($tableName){
        $table = self::$connection->query("SELECT * FROM `".$tableName."`");
        
        return $table;
    }

    public static function setConnection($connection){
        self::$connection = $connection;
    }

    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new MysqlStorage();
        }
        if(!isset(self::$instance)){
            return null;
        }
        return self::$instance;
    }

    public static function status(){
        if(isset($connection)){
            return 'isset';
        }
        return 'dont exist';
    }
}

?>