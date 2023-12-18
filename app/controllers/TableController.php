<?php

namespace App\Controllers;

use App\Models;
use App\Models\MysqlStorage;
use Core\Controller;

class TableController extends Controller
{

    public function add($table, $role){
        $row = [];

        foreach($_POST as $column => $value){
            $row[$column] = $value;
        }
        $this->storage->add($table, $row);

        return $this->redirect("/{$role}/{$table}");

    }

    public function delete($table, $role){

        $data = [];

        foreach($_POST as $column => $value){
            $data[$column] = $value;
        }

        if(true !== $data = $this->storage->delete($table, $data)){
            //return $this->view('main', ['data'=>$data, 'role'=>$role, 'tableName'=>$table]);
            
           // return $this->view('404',['message'=>"{$data}"]);

        }
        return $this->redirect("/{$role}/{$table}");


    }

    public function change(){
        
    }

    public function show($table, $role = 'guest')
    {
        if(false !== $data = $this->storage->fetch($table)){

            $fields = $this->storage->tableDetails($table);

            $fieldsTypes = [];

            foreach($fields as $field){
                $fieldsTypes[$field['Field']] = $this->adjustSqlTypesToHtml($field['Type']);
            }

            return $this->view('main', ['rows'=>$data, 'role'=>$role, 'tableName'=>$table,'types'=> $fieldsTypes]);
        }
        else {
            return $this->redirect("/{$role}");
        }

    }

    private function adjustSqlTypesToHtml($sqlType) {

        if(str_contains('enum',$sqlType)){
                return 'enum';
        }

        switch ($sqlType) {
            case 'int':
            case 'tinyint':
            case 'smallint':
            case 'mediumint':
            case 'bigint':
                return 'number';
    
            case 'float':
            case 'double':
            case 'decimal':
                return 'number'; // You might want to use 'text' or 'tel' depending on your requirements.
    
            case 'char':
            case 'varchar':
            case 'text':
            case 'tinytext':
            case 'mediumtext':
            case 'longtext':
                return 'text';
    
            case 'date':
                return 'date';
    
            case 'time':
                return 'time';
    
            case 'datetime':
            case 'timestamp':
                return 'datetime-local';
    
            default:{
                return 'text';
            }
        }
    }

}