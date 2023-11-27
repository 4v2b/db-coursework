<?php

namespace App\Controllers;

use App\Models\Storage;
use Core\Controller;

class HomeController extends Controller
{

    private $connection;

    private $storage;

    function __construct()
    {
       
        //$storage = new Storage($connection);
    }

    public function index()
    {
        $data = ['message' => 'Hello World!'];
        $this->render('main', $data);
    }


    public function showTable()
    {
        $tableName =  $_GET["table"];
        $table = $this->storage->getDataFromTable($tableName);
        $columns = $this->storage->getColumnNames($tableName);
        $this->render('main', ['table'=>$table, 'columns'=>$columns]);
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

        $connection = new \mysqli('localhost',$username, $password,'company');

        // Validate credentials (this is a basic example, in a real system, you'd hash passwords)
        if ($username === 'admin' && $password === 'password') {
            // Set a session variable to indicate that the user is authenticated
            $_SESSION['authenticated'] = true;
            echo 'Login successful!';
        } else {
            echo 'Invalid credentials';
        }
    }

    public function logout()
    {
        // Log the user out by destroying the session
        session_destroy();
        echo 'Logged out successfully!';
    }
}
