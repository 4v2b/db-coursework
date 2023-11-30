<?php

namespace App\Models;

use Exception;

class MysqlStorage implements Storage
{

    function __construct(private \mysqli $connection)
    {
    }

    public function getRole()
    {
        return str_replace(['%', '@', '`'], '', $this->connection
            ->query('SELECT current_role() AS role')
            ->fetch_assoc()['role']);
    }

    public function getGrants()
    {
        $rows = $this->connection->query('SHOW GRANTS');
        $grants = [];
        while ($row = $rows->fetch_assoc()) {
            $grants[] = $row;
        }
        return $grants;
    }

    public function fetch($tableName): array | bool
    {
        try {
            $table = $this->connection->query("SELECT * FROM `" . $tableName . "`");

            $result = [];

            while ($row = $table->fetch_assoc()) {
                $result[] = $row;
            }
            return ['rows' => $result];
        } catch (Exception $ex) {
            return false;
        }
    }

    public function query()
    {
    }


    public function delete($table, $conditions = ['id' => '0'])
    {
        try {
            $condition = '';

            foreach ($conditions as $column => $value) {
                $condition .= "{$column} = ";
                if(is_numeric($value)){
                    $condition .= "{$value}";
                } else{
                    $condition .= "'{$value}'";
                }
                $condition .= " AND ";
            }

            $length = strlen($condition);

            $condition = substr($condition, 0, $length - 4);

            $this->connection->query("DELETE FROM `{$table}` WHERE {$condition}");
            return true;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function change($table, $rows = [
        'ids' => [
            'id1' => 'value1',
            'id2' => 'value2'
        ],
        'newValues' => [
            'field1' => 'value1'
        ]
    ])
    {
        extract($rows);

        $this->connection->query("UPDATE TABLE {$table} SET somerow WHERE id = 'value'");
    }
}
