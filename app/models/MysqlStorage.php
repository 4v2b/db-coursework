<?php

namespace App\Models;

class MysqlStorage implements Storage{

    public function getRole(){
        return str_replace(['%','@','`'],'',$this->connection
                          ->query('SELECT current_role() AS role')
                          ->fetch_assoc()['role']);
    }

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

    public function getDataN($tableName){
        $table = $this->connection->query("SELECT * FROM `".$tableName."`");
        
        return $table;
    }

    public function query(){
    }


    public function delete($conditions = ['somefield'=>'somevalue']){
        extract($conditions);

        $this->connection->query("DELETE FROM TABLE {$table} WHERE id = 'value'");
    }

    public function change($table, $rows=[
        'ids'=>[
            'id1'=>'value1',
            'id2'=>'value2'
        ],
        'newValues'=>[
            'field1'=>'value1'
        ]
    ]){
        extract($rows);

        $this->connection->query("UPDATE TABLE {$table} SET somerow WHERE id = 'value'");
    }

}

?>