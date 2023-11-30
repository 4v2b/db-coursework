<?php

namespace App\Controllers;

use App\Models;
use App\Models\MysqlStorage;
use Core\Controller;

class TableController extends Controller
{

    public function add(){

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
            return $this->view('main', ['rows'=>$data['rows'], 'role'=>$role, 'tableName'=>$table]);
        }
        else {
            return $this->redirect("/{$role}");
        }

    }

}