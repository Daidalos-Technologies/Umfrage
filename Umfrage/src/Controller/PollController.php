<?php

namespace App\Controller;

class PollController extends \App\Template\Controller
{

    private $question_repository;
    private $result_repository;
    private $pollRepository;

    public function __construct($question_repository, $result_repository, $poll_repository)
    {
        $this->question_repository = $question_repository;
        $this->result_repository = $result_repository;
        $this->pollRepository = $poll_repository;
    }
    public function poll()
    {

        if(isset($_GET["poll_id"]))
        {
            $poll_id = $_GET["poll_id"];

            $check_poll = $this->pollRepository->find(["id", $poll_id]);

            if($check_poll)
            {
                $poll = $check_poll;
            }else
            {
                echo "Umfrage nicht gefunden! ";
                echo "<a href='./index'>Startseite</a>";
                die();
            }
        }else
        {
            echo "Umfrage nicht gefunden! ";
            echo "<a href='./index'>Startseite</a>";
            die();
        }

        if($poll['public'] == 0)
        {
            echo "Diese Umfrage ist noch nicht öffentlich! <a href='./index'>Startseite</a>";
            die();
        }


        if(isset($_POST["poll-start"]))
        {

            $question = $this->question_repository->findNext(1, 0, $poll_id);

            $answers_string = $question["answers"];
            $answers = json_decode($answers_string);

            $answers = (array)$answers;

            $this->render("Poll/Umfrage",
                [
                    "question" => $question,
                    "answers" => $answers,
                    "poll" => $poll
                ]);

            die();

        }


        if(isset($_POST["question-id"]))
        {

            $old_question = $this->question_repository->findByPoll(["id", $_POST["question-id"]], $poll_id);


        if(!isset($_POST["skip"])){

            if(!isset($_POST["answer"]))
            {
                $question = $old_question;
                $answers_string = $question["answers"];
                $answers = json_decode($answers_string);

                $answers = (array)$answers;
                $this->render("Poll/Umfrage",
                    [
                        "question" => $question,
                        "answers" => $answers,
                        "poll" => $poll
                    ]);

                die();
            }


            $check_result = $this->result_repository->checkResult($_SESSION["user_id"], $old_question["id"], $poll_id);

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
                $this->result_repository->addResult($_SESSION["user_id"], $_GET["poll_id"], $answer, $poll_id);
            }
        }else
        {
            $next_path = 0;
        }

        if($old_question["finish"] == 1)
        {
            setcookie("finish", $poll_id, time()+(3600*24*365));
           $user_results = $this->result_repository->allByUser($_SESSION["user_id"], $poll_id);
           $outro = $poll["outroduction"];

            $this->render("Poll/finish",
                [
                    "poll" => $poll,
                    "results" => $user_results,
                    "outro" => $outro
                ]);

            die();
        }

            $next_position = $old_question["position"] + 1;

            $question = $this->question_repository->findNext($next_position, $next_path, $poll_id);

            if($question)
            {

                $answers_string = $question["answers"];
                $answers = json_decode($answers_string);

                $answers = (array)$answers;
                $this->render("Poll/Umfrage",
                    [
                        "question" => $question,
                        "answers" => $answers,
                        "poll" => $poll
                    ]);
            }else
            {
              echo "Frage nicht gefunden!";
                die();
            }


        }else
        {
         $this->render("Poll/index",
         [
             "poll" => $poll,
         ]);
         die();
        }



    }

}