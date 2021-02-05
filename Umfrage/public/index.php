<?php
session_start();
if(isset($_COOKIE["finish"])){
    $_SESSION["user_id"] = $_COOKIE["finish"];
}else {
    if (!isset($_SESSION["user_id"])) {
        $hash = md5(time());
        $_SESSION["user_id"] = $hash;
    }
}
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
        ],
        "/poll_admin" =>
        [
            "controller" => "adminController",
            "method" => "poll_admin"
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
