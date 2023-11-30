<?php

namespace App\Controllers;

use App\Models\MysqlStorage;
use Core\Controller;
use Exception;

class AccessController extends Controller
{

    public function login()
    {
        if (isset($_SESSION['auth'])) {
            return $this->redirect("/" . $_SESSION['role'] . '/home');
        }

        return $this->view('login');
    }


    public function logout()
    {
        session_unset();
        session_destroy();

       return $this->redirect("/guest");
    }


    public function authenticate()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (Connection::try($username, $password) === false) {
            return $this->login();
        }

        $_SESSION['auth'] = true;
        $_SESSION['password'] = $password;
        $_SESSION['user'] = $username;

        $connection = Connection::make();
        $this->storage = new MysqlStorage($connection);

        $config = require __DIR__ . '/../config.php';

        $role = $this->storage->getRole();
        $grants = $this->storage->getGrants();

        if (in_array($role, $config['roles'])) {
            $_SESSION['role'] = $role;
            return $this->redirect("/{$role}/home");
        } else {
            $this->logout();
        }
    }



}
