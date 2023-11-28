<?php

namespace App\Models;

class MysqlStorage implements Storage{


    public function __construct(private \mysqli $connection)
    {
    }

    public function getDataTitles($tableName){
        $columns = $this->connection->query("SHOW COLUMNS FROM `".$tableName."`");
        return $columns;
    }

    public function getData($tableName){
        $table = $this->connection->query("SELECT * FROM `".$tableName."`");
        
        return $table;
    }

}

?>