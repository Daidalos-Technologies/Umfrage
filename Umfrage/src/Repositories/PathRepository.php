<?php


namespace App\Repositories;
use PDO;

class PathRepository extends \App\Template\Repository
{

    protected $table_name = "paths";
    protected $entity_path = "App\\Entities\\Path";

    public function add($number, $position, $poll_id)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `$this->table_name` (`number`, `position`, `poll`) VALUES (:number, :position, :poll)");
        $stmt->execute(["poll" => $poll_id, "position" => $position, "number" => $number]);
    }

    public function allByPosition ($poll)
    {
        $stmt = $this->pdo->query("SELECT * FROM `{$this->table_name}` WHERE poll = '$poll' ORDER BY position, number ");
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, "{$this->entity_path}");;
        return $res;
    }

}