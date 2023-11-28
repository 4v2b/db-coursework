<?php

namespace Core;

class Controller
{

    public function render($view, $data = [])
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
