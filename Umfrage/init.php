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

$user = "USER390976_bot";
$pass = "AntonderEroberer333#Archimedes333#";

try {
    $pdo = new PDO('mysql:host=antondereroberer.lima-db.de;dbname=db_390976_15', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
   // mysqli_query($pdo, "SET NAMES 'utf8'");

    function fetch_all($table)
    {
        global $pdo;
        $statement = $pdo->prepare("SELECT * FROM $table WHERE special = ? ORDER BY position ");
        $statement->execute(array(0));
        return $statement->fetchAll();
    }

    function fetch_by_position($position)
    {
        global $pdo;
        $statement = $pdo->prepare("SELECT * FROM questions WHERE position = ? ");
        $statement->execute(array($position));
        return $statement->fetch();
    }

    function fetch_by_id($id)
    {
        global $pdo;
        $statement = $pdo->prepare("SELECT * FROM questions WHERE id = ? ");
        $statement->execute(array($id));
        return $statement->fetch();
    }


    function add_result($user_id, $poll_id, $answer)
    {
        global $pdo;
        $statement = $pdo->prepare("INSERT INTO results (user_id, poll_id, answer) VALUES (?, ?, ?)");
        $statement->execute(array($user_id, $poll_id, $answer));

    }

    function fetch_result_by_user_id($user_id, $poll_id)
    {
        global $pdo;
        $statement = $pdo->prepare("SELECT * FROM results WHERE user_id = :user_id AND poll_id = :poll_id ");
        $statement->execute(array("user_id" => $user_id, "poll_id" => $poll_id));
        return $statement->fetch();
    }

    function update_result($user_id, $poll_id, $answer)
    {
        global $pdo;
        $statement = $pdo->prepare("UPDATE results SET answer = :answer WHERE user_id = :user_id AND poll_id = :poll_id");
        $statement->execute(array("answer" => $answer, "user_id" => $user_id, "poll_id" => $poll_id));
    }

    function fetch_all_by_user_id($user_id)
    {
        global $pdo;
        $statement = $pdo->prepare("SELECT * FROM results WHERE user_id = ? ORDER BY id");
        $statement->execute(array($user_id));
        return $statement->fetchAll();
    }

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}