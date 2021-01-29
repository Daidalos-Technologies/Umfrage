<?php

namespace App\Template;

use PDO;
use Exception;

abstract class Repository
{

    protected $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        if (empty($this->table_name) || empty($this->entity_path)) {
            throw new Exception(get_class($this) . " needs a table name and model path!");
        }
    }

    function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM `{$this->table_name}`");
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, "{$this->entity_path}");;
        return $res;
    }

    function allBy($col, $type)
    {
        $stmt = $this->pdo->query("SELECT * FROM `{$this->table_name}` ORDER BY $col $type");
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, "{$this->entity_path}");;
        return $res;
    }
}