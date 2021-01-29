<?php


namespace App\Template;


abstract class Controller
{
    public function render($view, $params)
    {
        extract($params);

        include __DIR__."/../../views{$view}.php";
    }

}