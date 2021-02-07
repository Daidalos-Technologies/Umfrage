<?php

$password = $_GET["pw"];
echo $password;
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;


