<?php
session_start();
if(isset($_COOKIE["finish"])){
    $_SESSION["result_id"] = $_COOKIE["finish"];
}else {
    if (!isset($_SESSION["result_id"])) {
        $hash = md5(time());
        $_SESSION["result_id"] = $hash;
    }
}

require __DIR__."/autoload.php";
$container = new App\Core\Container();


