<?php

namespace App\Controllers;

use App\Models\MysqlStorage;
use Core\Controller;
use Exception;

class HomeController extends Controller
{

    private MysqlStorage $storage;

    function __construct()
    {
      
        if(isset($_COOKIE['session_exist'])){   
            $connection = new \mysqli('localhost', 'root', 'password', 'company');
            MysqlStorage::setConnection($connection);
        }  
        $this->storage = MysqlStorage::getInstance();
    }

    public function index()
    {
        if (!isset($_COOKIE['session_exist'])) {
            $connection = new \mysqli('localhost', 'guest_user', '', 'company');
            MysqlStorage::setConnection($connection);
            $this->storage = MysqlStorage::getInstance();
        }
        $this->showTable();
    }

    public function showTable($table = 'order')
    {
        echo isset($_COOKIE['session_exist']);
        $table_ = $this->storage->getData($table);
        $columns =$this->storage->getDataTitles($table);
        $this->render('main', ['table' => $table_, 'columns' => $columns]);
    }

    public function login()
    {
        // Display the login form
        $this->render('login');
    }

    public function authenticate()
    {
        // Handle login form submission
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            $connection = new \mysqli('localhost', $username, $password, 'company');
            MysqlStorage::setConnection($connection);
            $this->storage = MysqlStorage::getInstance();
            //session_start();
            setcookie('session_exist',true,time()+60*10);
            //$_SESSION['authenticated'] = true;
            echo $_SESSION['authenticated'];
            header('Location: /database_coursework/public/show-table/country');
        } catch (Exception $ex) {
            setcookie('session_exist',true,time());
            //$_SESSION['authenticated'] = false;
            echo 'Invalid credentials';        
        }
    }

    public function logout()
    {
        setcookie('session_exist',true,time()-1);
        // Log the user out by destroying the session
        //session_destroy();
        echo 'Logged out successfully!';
    }
}
