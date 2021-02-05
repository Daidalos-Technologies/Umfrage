<?php


namespace App\Repositories;
use PDO;


class ResultRepository extends \App\Template\Repository
{
    protected $table_name = "results";
    protected $entity_path = "App\\Entities\\Result";

    function checkResult($user_id, $question_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `$this->table_name` WHERE user_id = '$user_id' AND question_id = '$question_id'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->entity_path);
        return $stmt->fetch(PDO::FETCH_CLASS);
    }

    function  addResult($user_id, $question_id, $answer)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `$this->table_name` (user_id, question_id, answer) VALUES (:user_id, :question_id, :answer)");
        $stmt->execute(["user_id" => $user_id, "question_id" => $question_id, "answer" => $answer]);

    }

    function updateResult($user_id, $question_id, $answer)
    {

    }
}