<?php

namespace App\Repositories;

use App\Template\Repository as Repository;
use PDO;
class QuestionRepository extends Repository
{

    protected $table_name = "questions";
    protected $entity_path = "App\\Entities\\Question";

    public function all_by_position ()
    {
        $stmt = $this->pdo->query("SELECT * FROM `{$this->table_name}` WHERE poll = '{$_SESSION['poll_admin']}' ORDER BY position ");
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, "{$this->entity_path}");;
        return $res;
    }

    public function addQuestion($title, $content, $position, $optional, $path, $answers, $answer_type, $poll)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `$this->table_name` (`title`, `content`, `position`, `optional`, `path`, `answers`, `answer_type`, `poll`) VALUES (:title, :content, :position, :optional, :path, :answers, :answer_type, :poll)");
        $stmt->execute(["title" => $title, "content" => $content, "position" => $position, "optional" => $optional, "path" => $path, "answers" => $answers, "answer_type" => $answer_type, "poll" => $poll ]);
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

    public function update($id, $title, $introduction)
    {

        $statement = $this->pdo->prepare("UPDATE polls SET title = :title, introduction = :introduction WHERE id = :id");
        $statement->execute(array("title" => $title, "introduction" => $introduction, "id" => $id));
    }









}