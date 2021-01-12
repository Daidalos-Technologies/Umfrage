<?php
$user = "USER390976_bot";
$pass = "AntonderEroberer333#Archimedes333#";

try {
    $pdo = new PDO('mysql:host=antondereroberer.lima-db.de;dbname=db_390976_15', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
   // mysqli_query($pdo, "SET NAMES 'utf8'");

    function fetch_all($table)
    {
        global $pdo;
        $statement = $pdo->prepare("SELECT * FROM $table ORDER BY position");
        $statement->execute();
        return $statement->fetchAll();
    }

    function fetch_by_position($position)
    {
        global $pdo;
        $statement = $pdo->prepare("SELECT * FROM poll WHERE position = ? ");
        $statement->execute(array($position));
        return $statement->fetch();
    }

    function fetch_by_id($id)
    {
        global $pdo;
        $statement = $pdo->prepare("SELECT * FROM poll WHERE id = ? ");
        $statement->execute(array($id));
        return $statement->fetch();
    }

    function add_result($user_id, $poll_id, $answer)
    {
        global $pdo;
        $statement = $pdo->prepare("INSERT INTO results (user_id, poll_id, answer) VALUES (?, ?, ?)");
        $statement->execute(array($user_id, $poll_id, $answer));

    }

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}