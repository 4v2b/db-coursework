<?php

namespace App\Controllers;

class Connection{

    public static function getConnection()
    {
        if(isset( $_SESSION['auth'])){   
            $connection = new \mysqli('localhost', $_SESSION['user'], $_SESSION['password'], 'company');
        } 
        else{
            $connection = new \mysqli('localhost', 'guest_user','', 'company');
        } 
        return $connection;
    }

}