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
    $error = true;

    // Initialise Question Attributes

    if(isset($_POST["title"]))
    {
        $title = $_POST["title"];
        $content = $_POST["content"];
        $position = $_POST["position"];

        if($position == "self-filling")
        {
            $position = $_POST["individual-position"];
        }
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

        // Create Answer - Array

         $answers = [];

         for ($i = 1; $i <= $answer_counter; $i++)
         {
             if($i == $answer_counter)
             {
                 if($answer_type == "self-filling" || $answer_type == "select+self-filling" || $answer_type == "checkbox+self-filling")
                 {
                     array_push($answers, [
                         "answer-content" => $_POST["answer-$i"],
                         "type" => "self-filling",
                         "path" => $_POST["pathfinder-$i"]

                     ]);
                 }else
                 {
                     array_push($answers, [
                         "answer-content" => $_POST["answer-$i"],
                         "type" => "default",
                         "path" => $_POST["pathfinder-$i"]

                     ]);
                 }

             }else
             {
                 array_push($answers, [
                     "answer-content" => $_POST["answer-$i"],
                     "type" => "default",
                     "path" => $_POST["pathfinder-$i"]

                 ]);
             }
         }

         // Serialize Answer-Array

        $answers_string = json_encode($answers);

         // Create Database-Entry


        if($this->question_repository->check($position, $path) == false)
        {
            $this->question_repository->addQuestion($title, $content, $position, $optional, $path, $answers_string, $answer_type);
            $error = false;
        }else
        {
            $error = "Bitte gib der Frage eine andere Position oder Pfad";
        }
        // header("Location: ./poll_admin?page=add_questions");


    }


    $all_questions = $this->question_repository->all_by_position();
    $last_question = end($all_questions);

    $this->render("Admin/Add",[
        "all_questions" => $all_questions,
        "last_question" => $last_question,
        "error" => $error,

    ]);
}


    }

}