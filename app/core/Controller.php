<?php

namespace Core;

class Controller
{

    public function render($view, $data = [])
    {
        extract($data);
        include __DIR__ . "/../views/{$view}.view.php";
    }
}
