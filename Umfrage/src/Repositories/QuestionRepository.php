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
        $stmt = $this->pdo->query("SELECT * FROM `{$this->table_name}` ORDER BY position");
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, "{$this->entity_path}");;
        return $res;
    }

    public function addQuestion($title, $content, $position, $optional, $path, $answers, $answer_type)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `$this->table_name` (`title`, `content`, `position`, `optional`, `path`, `answers`, `answer_type`) VALUES (:title, :content, :position, :optional, :path, :answers, :answer_type)");
        $stmt->execute(["title" => $title, "content" => $content, "position" => $position, "optional" => $optional, "path" => $path, "answers" => $answers, "answer_type" => $answer_type]);
    }

    function check($position, $path)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `$this->table_name` WHERE position = $position AND path = $path");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->entity_path);
        return $stmt->fetch(PDO::FETCH_CLASS);
    }

    function findNext($position, $path)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `$this->table_name` WHERE position = '$position' AND path = '$path'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->entity_path);
        return $stmt->fetch(PDO::FETCH_CLASS);
    }





}