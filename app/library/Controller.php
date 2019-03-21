<?php

namespace app\library;

class Controller
{
    public function view($name, $data = [])
    {
        extract($data);
        $path = 'app/views/' . $name . '.php';
        if (file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean();
            require 'app/views/layout.php';
        }
    }

    public function model($name)
    {
        $path = 'app\models\\' . $name . 'Model';
        if (class_exists($path)) {
            return new $path;
        }
    }
}