<?php

namespace App\Controllers;

use App\Controllers\Connection;
use App\Models\MysqlStorage;
use Core\Controller;

class HomeController extends Controller
{

    public function home($role = 'guest')
    {
        if (!isset($_SESSION['auth'])) {
            $_SESSION['role'] = 'guest';
        }

        if ($role !== $_SESSION['role']) {
            return $this->redirect("/" . $_SESSION['role']);
        }

        return $this->view($role . '-main');
    }
}
