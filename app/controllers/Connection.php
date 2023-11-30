<?php

namespace App\Controllers;

use Exception;

class Connection
{

    public static function make(): bool | \mysqli
    {
        try {
            $config = include __DIR__ . '/../config.php';
            $server = $config['database']['server'];
            $database = $config['database']['name'];

            if (isset($_SESSION['auth'])) {
                $connection = new \mysqli($server, $_SESSION['user'], $_SESSION['password'], $database);
            } else {
                $connection = new \mysqli($server, 'guest_user', '', $database);
            }
        } catch (Exception $ex) {
            return false;
        }
        return $connection;
    }

    public static function try($user, $password)
    {
        try {
            $config = include __DIR__ . '/../config.php';
            $server = $config['database']['server'];
            $database = $config['database']['name'];
            $connection = new \mysqli($server, $user, $password, $database);
            $connection->close();
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}
