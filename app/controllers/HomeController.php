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
        $connection = Connection::make();
        $this->storage = new MysqlStorage($connection);
    }

    public function index()
    {
    }

    public function login()
    {
        if (isset($_SESSION['auth'])) {
            $this->redirect("/" . $_SESSION['role'] . '/home');
        }
        // Display the login form
        $this->render('login');
    }

    public function authenticate()
    {
        // Handle login form submission
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (Connection::make() !== false) {
            $_SESSION['auth'] = true;
            $_SESSION['password'] = $password;
            $_SESSION['user'] = $username;
            $_SESSION['role'] = 'admin';

            setcookie('session_exist', true, time() + 60 * 10);

            //Unnececary
            $connection = Connection::make();
            $this->storage = new MysqlStorage($connection);

            $role = $_SESSION['role'];
            $this->redirect("/{$role}/home");
        } else {
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

        $this->redirect("/");
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
        $rows = $this->storage->getData($table);
        $titles = $this->storage->getDataTitles($table);

        $this->render('main', ['table' => $rows, 'columns' => $titles]);
    }
}
