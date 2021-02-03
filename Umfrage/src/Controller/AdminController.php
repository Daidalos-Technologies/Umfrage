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
    $error = false;
    if(isset($_POST["title"]))
    {
        $title = $_POST["title"];
        $content = $_POST["content"];
        $position = $_POST["position"];
        if(isset($_POST["optional"]))
        {
            $optional = 1;
        }else
        {
            $optional = 0;
        }

        if(isset($_POST["path-question"]))
        {
            $path = $_POST["path"];
        }else
        {
            $path = 0;
        }

        $answer_type = $_POST["answer-type"];
        $answer_counter = $_POST["answer-counter"];
    }


    $all_questions = $this->question_repository->all_by_position();
    $last_question = end($all_questions);
    $this->render("Admin/Add",[
        "all_questions" => $all_questions,
        "last_question" => $last_question,
        "error" => $error
    ]);
}


    }

}