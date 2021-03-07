<?php


namespace App\Repositories;
use PDO;

class AnswerRepository extends \App\Template\Repository
{
    protected $table_name = "answers";
    protected $entity_path = "App\\Entities\\Answer";

    public function add($content, $question_id, $next_position, $next_path)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `$this->table_name` (`content`, `question_id`, `next_position`, `next_path`) VALUES (:content, :question_id, :next_position, :next_path)");
        $stmt->execute(["content" => $content, "question_id" => $question_id, "next_position" => $next_position, "next_path" => $next_path]);
        return $this->pdo->lastInsertId();
    }
}