<?php

namespace App\Controller;

class PollController extends \App\Template\Controller
{

    private $question_repository;

    public function __construct($question_repository)
    {
        $this->question_repository = $question_repository;
    }
    public function poll()
    {

        if (!isset($_POST["question_pos"]) || $_POST["question_pos"] == 1)
        {
            $question = $this->question_repository->find(["position", 1]);
        }else
        {
            $question = $this->question_repository->find(["position", $_POST["question_pos"]]);
        }



        $this->render("Umfrage",
        [
            "question" => $question
        ]);
    }

}