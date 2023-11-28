<?php

namespace App\Controllers;

use App\Controllers\Connection;
use App\Models\MysqlStorage;
use Core\Controller;
use Exception;

class HomeController extends Controller
{

    private MysqlStorage $storage;

    function __construct()
    {
        MysqlStorage::setConnection(Connection::getConnection());
        $this->storage = MysqlStorage::getInstance();
    }

    public function index()
    {
    }

    public function login()
    {
        if (isset($_SESSION['auth'])) {
            header("Location: /db-coursework/public/" . $_SESSION['role'] . '/home');
        }
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
            setcookie('session_exist', true, time() + 60 * 10);
            //$_SESSION['authenticated'] = true;
            $_SESSION['auth'] = true;
            $_SESSION['password'] = $password;
            $_SESSION['user'] = $username;
            $_SESSION['role'] = 'admin';

            $role = $_SESSION['role'];

            header("Location: /db-coursework/public/{$role}/home");
        } catch (Exception $ex) {
            setcookie('session_exist', true, time());
            $_SESSION['auth'] = false;
            echo 'Invalid credentials';
        }
    }

    public function logout()
    {
        setcookie('session_exist', true, time() - 1);
        // Log the user out by destroying the session
        session_unset();
        session_destroy();
        echo 'Logged out successfully!';
        header("Location: /db-coursework/public/");
    }

    public function home($role)
    {
        if (isset($_SESSION['auth'])) {
            $role = $_SESSION['role'];
        } else {
            $role = 'guest';
        }
        $this->render($role . '-main');
    }

    public function show($table, $role = 'guest')
    {
        $storage = MysqlStorage::getInstance();
        $rows = $storage->getData($table);
        $titles = $storage->getDataTitles($table);

        $this->render('main', ['table' => $rows, 'columns' => $titles]);
    }
}
