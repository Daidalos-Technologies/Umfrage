<?php


namespace App\Controller;


class AdminController extends \App\Template\Controller
{
    private $question_repository;
    private $result_repository;
    private $poll_repository;

    public function __construct($question_repository, $result_repository, $poll_repository)
    {
        $this->question_repository = $question_repository;
        $this->result_repository = $result_repository;
        $this->poll_repository = $poll_repository;
    }

    public function poll_admin()
    {

        if (isset($_POST["logout"])) {
            unset($_SESSION["poll_admin"]);
        }

        $login = false;

        if (!isset($_SESSION["poll_admin"])) {
            if (isset($_POST["id"])) {
                $id = $_POST["id"];
                $password = $_POST["password"];
                $accessed_poll = $this->poll_repository->find(["id", $id]);

                if (password_verify($password, $accessed_poll["admin_pw"])) {

                    $_SESSION["poll_admin"] = $id;
                    $login = true;

                } else {
                    $this->render("Admin/password_checker", [
                        "error" => "Das <b>Passwort</b> stimmt nicht mit der <b>ID</b> über ein",
                        "poll_admin" => 1
                    ]);
                }


            } else {
                $this->render("Admin/password_checker", [
                    "poll_admin" => 1
                ]);
            }
        } else {
            $login = true;
        }

        if (!$login) {
            die();
        }

        if (isset($_POST["public"])) {
            $this->poll_repository->updatePublic($_SESSION["poll_admin"], $_POST["public"]);
        }


        if (!isset($_GET["page"])) {
            $this->render("Admin/Index", [
                "poll" => $this->poll_repository->find(["id", $_SESSION["poll_admin"]])
            ]);
        } else if ($_GET["page"] === "add_questions") {

            $error = null;

            // Initialise Question Attributes

            if (isset($_POST["title"])) {
                $title = $_POST["title"];
                $content = $_POST["content"];
                $position = $_POST["position"];

                if ($position == "self-filling") {
                    $position = $_POST["individual-position"];
                }
                if (isset($_POST["optional"])) {
                    $optional = 1;
                } else {
                    $optional = 0;
                }

                if (isset($_POST["finish"])) {
                    $finish = 1;
                } else {
                    $finish = 0;
                }

                if (isset($_POST["path-question"])) {
                    $path = $_POST["path"];
                } else {
                    $path = 0;
                }

                $answer_type = $_POST["answer-type"];
                $answer_counter = $_POST["answer-counter"];

                // Create Answer - Array

                $answers = [];

                for ($i = 1; $i <= $answer_counter; $i++) {
                    if ($i == $answer_counter) {
                        if ($answer_type == "self-filling" || $answer_type == "select+self-filling" || $answer_type == "checkbox+self-filling") {
                            array_push($answers, [
                                "answer-content" => $_POST["answer-$i"],
                                "type" => "self-filling",
                                "path" => 0

                            ]);
                        } else {
                            array_push($answers, [
                                "answer-content" => $_POST["answer-$i"],
                                "type" => "default",
                                "path" => 0

                            ]);
                        }

                    } else {
                        array_push($answers, [
                            "answer-content" => $_POST["answer-$i"],
                            "type" => "default",
                            "path" => 0

                        ]);
                    }
                }

                // Serialize Answer-Array

                $answers_string = json_encode($answers);

                // Create Database-Entry


                if ($this->question_repository->check($position, $path) == false) {
                    $this->question_repository->addQuestion($title, $content, $position, $optional, $finish, $path, $answers_string, $answer_type, $_SESSION["poll_admin"]);
                    $error = false;
                } else {
                    $error = "Bitte gib der Frage eine andere Position oder Pfad";
                }
                // header("Location: ./poll_admin?page=add_questions");


            }


            $all_questions = $this->question_repository->all_by_position();
            $last_question = end($all_questions);

            $this->render("Admin/Add", [
                "all_questions" => $all_questions,
                "last_question" => $last_question,
                "error" => $error,
                "poll" => $this->poll_repository->find(["id", $_SESSION["poll_admin"]])

            ]);
        } else if ($_GET["page"] === "settings") {

            if (isset($_POST["title"])) {
                $id = $_POST["id"];
                $title = $_POST["title"];
                $introduction = $_POST["introduction"];
                $outroduction = $_POST["outroduction"];
                $this->poll_repository->update($id, $title, $introduction, $outroduction);

                $this->render("Admin/Settings",
                    [
                        "poll" => $this->poll_repository->find(["id", $_SESSION["poll_admin"]]),
                        "success" => "Umfrage erfolgreich aktualisiert!"

                    ]);
            } else {
                $this->render("Admin/Settings",
                    [
                        "poll" => $this->poll_repository->find(["id", $_SESSION["poll_admin"]])

                    ]);
            }


        } else if ($_GET["page"] == "results") {

            $results = [];
            $questions = $this->question_repository->allByPoll($_SESSION["poll_admin"]);

            foreach ($questions as $question) {
                $question_results = $this->result_repository->allByQuestion($question["id"], $_SESSION["poll_admin"]);

                array_push(
                    $results,
                    [
                        "question" => $question,
                        "question_results" => $question_results

                    ]
                );
            };


            $this->render("Admin/Results",
                [
                    "poll" => $this->poll_repository->find(["id", $_SESSION["poll_admin"]])
                ]
            );
        } else if ($_GET["page"] == "edit") {
            $success = false;
            if (isset($_POST["delete"])) {
                $this->question_repository->delete($_POST["delete"], $_SESSION["poll_admin"]);

                $success = "Die Frage mit der ID {$_POST['delete']} wurde erfolgreich gelöscht";
            } else if (isset($_POST["edit-id"])) {
                $questions = $this->question_repository->allByPoll($_SESSION["poll_admin"]);
                $question = $this->question_repository->find(["id", $_POST["edit-id"]]);
                $answers_string = $question["answers"];
                $answers = json_decode($answers_string);

                $answers = (array)$answers;


                $this->render("Admin/Edit", [
                    "poll" => $this->poll_repository->find(["id", $_SESSION["poll_admin"]]),
                    "questions" => $questions,
                    "edit_question" => $question,
                    "answers" => $answers
                ]);

                die();
            } else if (isset($_POST["edit"])) {
                $id = $_POST["id"];
                $title = $_POST["title"];
                $content = $_POST["content"];
                $position = $_POST["position"];
                if(isset($_POST["pathfinder"]))
                {
                    $pathfinder = $_POST["pathfinder"];
                }

                $path = $_POST["path"];
                if(isset($_POST["finish"]))
                {
                    $finish = 1;
                }else
                {
                    $finish = 0;
                }
                if(isset($_POST["optional"]))
                {
                    $optional = 1;
                }else
                {
                    $optional = 0;
                }
                $answers = $_POST["answer"];
                $temp_answers = [];
                $temp_counter = 0;
                foreach ($answers as $answer) {
                    if(isset($_POST["pathfinder"]))
                    {
                        array_push($temp_answers, [
                            "answer-content" => $answer,
                            "type" => "default",
                            "path" => $pathfinder[$temp_counter]

                        ]);
                    }else
                    {
                        array_push($temp_answers, [
                            "answer-content" => $answer,
                            "type" => "default",
                            "path" => 0

                        ]);
                    }

                    $temp_counter++;
                }

                $answers_string = json_encode($temp_answers);

                $this->question_repository->update($id, $title, $content, $answers_string, $position, $path, $optional, $finish);

                $success = "Die Frage mit der ID {$id} wurde erfolgreich aktualisiert";

            }

            $questions = $this->question_repository->allByPoll($_SESSION["poll_admin"]);

            $this->render("Admin/Edit", [
                "poll" => $this->poll_repository->find(["id", $_SESSION["poll_admin"]]),
                "questions" => $questions,
                "success" => $success
            ]);
        }


    }

    public function system_admin()
    {
        $hash = '$2y$10$aSnG4Ly6zN9znQLVVZx9keIIK/t0s4CbOaaBobb0JLlZnMX9eZEpu';

        // Login Check
        $login = false;
        if (!isset($_SESSION["system_admin"])) {
            if (isset($_POST["password"])) {
                $password = $_POST["password"];

                if (password_verify($password, $hash)) {
                    $login = true;
                    $_SESSION["system_admin"] = 1;
                } else {
                    $this->render("Admin/password_checker",
                        [
                            "error" => "Falsches Passwort!"
                        ]);

                }

            } else {
                $this->render("Admin/password_checker", []);
            }
        } else {
            $login = true;
        }

        if ($login) {
            if (isset($_POST["poll-password"])) {
                $poll_password = $_POST["poll-password"];
                $poll_password = password_hash($poll_password, PASSWORD_DEFAULT);
                $this->poll_repository->add($poll_password);
            }

            $polls = $this->poll_repository->all();
            $this->render("Admin/System_Admin", [
                "polls" => $polls
            ]);
        }


    }

}