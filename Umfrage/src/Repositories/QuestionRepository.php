<?php

namespace App\Repositories;

use App\Template\Repository as Repository;
use PDO;
class QuestionRepository extends Repository
{

    protected $table_name = "questions";
    protected $entity_path = "App\\Entities\\Question";

    public function allByPosition ($poll)
    {
        $stmt = $this->pdo->query("SELECT * FROM `{$this->table_name}` WHERE poll = '$poll' ORDER BY position, path ");
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, "{$this->entity_path}");;
        return $res;
    }

    public function add($title, $content, $position, $optional, $finish, $path, $answers, $answer_type, $poll)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `$this->table_name` (`title`, `content`, `position`, `optional`, `finish`, `path`, `answers`, `answer_type`, `poll`) VALUES (:title, :content, :position, :optional, :finish, :path, :answers, :answer_type, :poll)");
        $stmt->execute(["title" => $title, "content" => $content, "position" => $position, "optional" => $optional, "finish" => $finish, "path" => $path, "answers" => $answers, "answer_type" => $answer_type, "poll" => $poll ]);
        return $this->pdo->lastInsertId();
    }

    public function updateSpec($id, $params)
    {

        $statement = $this->pdo->prepare("UPDATE `$this->table_name` SET {$params[0]} = :placeholder WHERE id = :id");
        $statement->execute(array("placeholder" => $params[1], "id" => $id));
    }

    public function check($position, $path)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `$this->table_name` WHERE position = $position AND path = $path AND poll = {$_SESSION['poll_admin']}");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->entity_path);
        return $stmt->fetch(PDO::FETCH_CLASS);
    }

    public function findNext($position, $path, $poll)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `$this->table_name` WHERE position = '$position' AND path = '$path' AND poll = '$poll'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->entity_path);
        return $stmt->fetch(PDO::FETCH_CLASS);
    }

    public function delete($question_id, $poll)
    {
        $statement = $this->pdo->prepare("DELETE FROM `$this->table_name` WHERE id = :question_id AND poll = :poll");
        $statement->execute(array('question_id' => $question_id, 'poll' => $poll));
    }

    public function update($id, $title, $content, $answers, $position, $path, $optional, $finish)
    {

        $statement = $this->pdo->prepare("UPDATE `$this->table_name` SET title = :title, content = :content, answers = :answers, position = :position, path = :path, optional = :optional, finish = :finish WHERE id = :id");
        $statement->execute(array("title" => $title, "content" => $content, "answers" => $answers, "position" => $position, "path" => $path, "optional" => $optional, "finish" => $finish, "id" => $id));
    }












}