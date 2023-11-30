<?php

namespace Core;

use App\Models\MysqlStorage;
use App\Controllers\Connection;

class Controller
{
    protected MysqlStorage $storage;

    function __construct()
    {
        $connection = Connection::make();
        $this->storage = new MysqlStorage($connection);
    }

    public function view($view, $data = [])
    {
        extract($data);
        $root = $this->getUrlBase();
        require __DIR__ . "/../views/{$view}.view.php";
    }

    private function getUrlBase() {
        $config = include __DIR__.'/../config.php';
        return isset($config['url_base']) ? $config['url_base']: '';
    }

    public function redirect($url){
        header("Location: ".$this->getUrlBase().$url);
    }
}
