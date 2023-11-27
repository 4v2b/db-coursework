<?php

namespace App\Models;

class Storage{
    function __construct(private \mysqli $connection)
    {
        
    }

    public function getDataFromTable($tableName){
        $table = $this->connection->query("SELECT * FROM `".$tableName."`");
        
        return $table;
    }

    public function getColumnNames($tableName){
        $columns = $this->connection->query("SHOW COLUMNS FROM `".$tableName."`");
        return $columns;
    }
}

?>