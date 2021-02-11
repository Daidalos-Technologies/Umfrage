<?php


namespace App\Repositories;
use PDO;

class PollRepository extends \App\Template\Repository
{
    protected $table_name = "polls";
    protected $entity_path = "App\\Entities\\Poll";

    public function add($poll_password)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `$this->table_name` (title, introduction, outroduction, admin_pw, public) VALUES (:title, :introduction, :outroduction, :admin_pw, :public)");
        $stmt->execute(["title" => "Titel der Umfrage", "introduction" => "Einleitende Worte...", "outroduction" => "Vielen Dank für Ihre Teilnahme",  "admin_pw" => $poll_password, "public" => 0]);
    }

    public function update($id, $title, $introduction, $outroduction)
    {

        $statement = $this->pdo->prepare("UPDATE polls SET title = :title, introduction = :introduction, outroduction = :outroduction WHERE id = :id");
        $statement->execute(array("title" => $title, "introduction" => $introduction, "outroduction" => $outroduction, "id" => $id));
    }

    public function updatePublic ($id, $public)
    {
        $statement = $this->pdo->prepare("UPDATE polls SET public = :public WHERE id = :id");
        $statement->execute(array("public" => $public, "id" => $id));
    }

}