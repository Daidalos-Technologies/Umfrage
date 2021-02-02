<?php


namespace App\Controller;


class AdminController extends \App\Template\Controller
{
    private $question_repository;

    public function __construct($question_repository)
    {
        $this->question_repository = $question_repository;
    }

    public function poll_admin()
    {
if(!isset($_GET["page"]))
{
    $this->render("Admin/Index",[]);
}else  if($_GET["page"] === "add_questions")
{
    $this->render("Admin/Add",[]);
}


    }

}