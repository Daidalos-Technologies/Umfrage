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

    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM `{$this->table_name}`");
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, "{$this->entity_path}");;
        return $res;
    }

    public function allBy($col, $type)
    {
        $stmt = $this->pdo->query("SELECT * FROM `{$this->table_name}` ORDER BY $col $type");
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, "{$this->entity_path}");;
        return $res;
    }

    public function find($params)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `$this->table_name` WHERE {$params[0]}= :placeholder");
        $stmt->execute(["placeholder" => $params[1]]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->entity_path);
        return $stmt->fetch(PDO::FETCH_CLASS);
    }

    public function findByPoll($params, $poll)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `$this->table_name` WHERE {$params[0]}= :placeholder");
        $stmt->execute(["placeholder" => $params[1]]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->entity_path);
        return $stmt->fetch(PDO::FETCH_CLASS);
    }

    public function allByPoll($poll)
    {
        $stmt = $this->pdo->query("SELECT * FROM `{$this->table_name}` WHERE poll = '$poll' ORDER BY position");
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, "{$this->entity_path}");;
        return $res;
    }

    public function last($col)
    {
        $stmt = $this->pdo->prepare("SELECT *
FROM `{$this->table_name}`
ORDER BY {$col} DESC
LIMIT 1");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->entity_path);
        return $stmt->fetch(PDO::FETCH_CLASS);
    }


}