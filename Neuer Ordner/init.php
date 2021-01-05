<?php
$user = "USER390976_bot";
$pass = "AntonderEroberer333#Archimedes333#";

try {
    $pdo = new PDO('mysql:host=antondereroberer.lima-db.de;dbname=db_390976_15', $user, $pass);

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}