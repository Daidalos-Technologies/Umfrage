<?php

namespace App\Repositories;

use App\Template\Repository as Repository;
use PDO;
class QuestionRepository extends Repository
{

    protected $table_name = "questions";
    protected $entity_path = "App\\Entities\\Question";

    public function all_default ()
    {
        $stmt = $this->pdo->query("SELECT * FROM `{$this->table_name}` WHERE special = 0 ORDER BY position");
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, "{$this->entity_path}");;
        return $res;
    }

}