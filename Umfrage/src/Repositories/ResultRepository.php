<?php


namespace App\Repositories;
use PDO;


class ResultRepository extends \App\Template\Repository
{
    protected $table_name = "results";
    protected $entity_path = "App\\Entities\\Result";

    public function checkResult($user_id, $question_id, $poll)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `$this->table_name` WHERE user_id = '$user_id' AND question_id = '$question_id' AND poll = '$poll'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->entity_path);
        return $stmt->fetch(PDO::FETCH_CLASS);
    }

    public function  addResult($user_id, $question_id, $answer, $poll)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `$this->table_name` (user_id, question_id, answer, poll) VALUES (:user_id, :question_id, :answer, :poll)");
        $stmt->execute(["user_id" => $user_id, "question_id" => $question_id, "answer" => $answer, "poll" => $poll]);

    }

    public function update($id, $answer)
    {

        $statement = $this->pdo->prepare("UPDATE `$this->table_name` SET answer = :answer WHERE id = :id");
        $statement->execute(array("id" => $id, "answer" => $answer));
    }

    public function updateFinish($id)
    {

        $statement = $this->pdo->prepare("UPDATE `$this->table_name` SET finish = :finish WHERE user_id = :id");
        $statement->execute(array("id" => $id, "finish" => 1));
    }

    public function allByPoll($poll)
    {
        $stmt = $this->pdo->query("SELECT * FROM `{$this->table_name}` WHERE poll = '$poll' AND finish = 1");
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, "{$this->entity_path}");;
        return $res;
    }

    public function allByPollNotFinish($poll)
    {
        $stmt = $this->pdo->query("SELECT * FROM `{$this->table_name}` WHERE poll = '$poll'");
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, "{$this->entity_path}");;
        return $res;
    }



    public function allByQuestion($question_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `$this->table_name` WHERE question_id = :question_id AND finish = 1");
        $stmt->execute(["question_id" => $question_id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->entity_path);
        return $stmt->fetchAll(PDO::FETCH_CLASS);

    }

    public function allByUser($user_id, $poll)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `$this->table_name` WHERE user_id = :user_id AND poll = :poll AND finish = 1");
        $stmt->execute(["user_id" => $user_id, "poll" => $poll]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->entity_path);
        return $stmt->fetch(PDO::FETCH_CLASS);

    }

    public function count ($poll_id)
    {
        $statement = $this->pdo->prepare("SELECT COUNT(DISTINCT user_id) AS anzahl FROM `$this->table_name` WHERE poll = :poll_id AND finish = 1");
        $statement->execute(array("poll_id" => $poll_id));
        return $statement->fetch();
    }


}