<?php

namespace App\Controllers;

use App\Controllers\Connection;
use App\Models\MysqlStorage;
use Core\Controller;

class HomeController extends Controller
{
    private MysqlStorage $storage;

    function __construct()
    {
        $connection = Connection::make();
        $this->storage = new MysqlStorage($connection);
    }

    public function login()
    {
        if (isset($_SESSION['auth'])) {
            $this->redirect("/" . $_SESSION['role'] . '/home');
        }
        // Display the login form
        return $this->render('login');
    }

    public function authenticate()
    {
        // Handle login form submission
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (Connection::make() === false) {
            $this->login();
        }

        $_SESSION['auth'] = true;
        $_SESSION['password'] = $password;
        $_SESSION['user'] = $username;

        $connection = Connection::make();
        $this->storage = new MysqlStorage($connection);

        $config = require __DIR__ . '/../config.php';

        $role = $this->storage->getRole();

        if (in_array($role, $config['roles'])) {
            $_SESSION['role'] = $role;
            $this->redirect("/{$role}/home");
        } else {
            $this->logout();
        }
    }

    public function logout()
    {
        //setcookie('session_exist', true, time() - 1);
        // Log the user out by destroying the session
        session_unset();
        session_destroy();
        //echo 'Logged out successfully!';

       $this->redirect("/guest");
    }

    public function home($role = 'guest')
    {
        if (!isset($_SESSION['auth'])) {
            $_SESSION['role'] = 'guest';
        }

        if ($role !== $_SESSION['role']) {
            $this->redirect("/" . $_SESSION['role']);
        }

        return $this->render($role . '-main');
    }

    public function show($table, $role = 'guest')
    {
        $rows = $this->storage->getData($table);
        $titles = $this->storage->getDataTitles($table);

        return $this->render('main', ['table' => $rows, 'columns' => $titles]);
    }
}
