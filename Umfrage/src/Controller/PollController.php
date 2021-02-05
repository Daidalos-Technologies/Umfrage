<?php

namespace App\Controller;

class PollController extends \App\Template\Controller
{

    private $question_repository;
    private $result_repository;

    public function __construct($question_repository, $result_repository)
    {
        $this->question_repository = $question_repository;
        $this->result_repository = $result_repository;
    }
    public function poll()
    {



        if(isset($_POST["question-id"]))
        {
            $old_question = $this->question_repository->find(["id", $_POST["question-id"]]);


        if($_POST["skip"] != 1){
            $check_result = $this->result_repository->checkResult($_SESSION["user_id"], $old_question["id"]);

            $answer = $_POST["answer"];

            $next_path = $_POST["next-path"];

            if($answer == "self-filling")
            {
                $answer = $_POST["self-answer"];
            }
            if(is_array($answer))
            {
                $answer = implode("#", $answer);
            }

            if($check_result == true)
            {

            }else
            {
                $this->result_repository->addResult($_SESSION["user_id"], $old_question["id"], $answer);
            }
        }else
        {
            $next_path = 0;
        }


            $next_position = $old_question["position"] + 1;

            $question = $this->question_repository->findNext($next_position, $next_path);


        }else
        {
          $question = $this->question_repository->find(["position", 1]);
        }

        $answers_string = $question["answers"];
        $answers = json_decode($answers_string);

        $answers = (array)$answers;





        $this->render("Umfrage",
        [
            "question" => $question,
            "answers" => $answers
        ]);
    }

}