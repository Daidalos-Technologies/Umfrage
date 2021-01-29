<?php
session_start();
require __DIR__."/../init.php";

if(!isset($_SERVER["PATH_INFO"])) {
    header("Location: index.php/index");
}else {
    $pathInfo = $_SERVER['PATH_INFO'];
}

$routes =
    [
        "/umfrage" => [
            "controller" => "pollController",
            "method" => "poll"
        ]
    ];

if(isset($routes[$pathInfo])) {
    $route = $routes[$pathInfo];
    $controller = $container->make($route["controller"]);
    $method = $route["method"];
    $controller->$method();
}else {
    echo "Die Seite konnte nicht gefunden werden. <br>";
    echo "Kehre zu <a href='./index'>Startseite</a> zurück";
    die();
}
