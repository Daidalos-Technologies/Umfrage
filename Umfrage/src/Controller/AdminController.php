<?php


namespace App\Controller;


class AdminController extends \App\Template\Controller
{
    private $question_repository;
    private $result_repository;
    private $poll_repository;
    /**
     * @var mixed
     */
    private $poll_id;

    public function __construct($question_repository, $result_repository, $poll_repository)
    {
        $this->question_repository = $question_repository;
        $this->result_repository = $result_repository;
        $this->poll_repository = $poll_repository;

        if (isset($_SESSION["poll_admin"])) {
            $this->poll = $this->poll_repository->find(["id", $_SESSION["poll_admin"]]);
            $this->poll_id = $_SESSION["poll_admin"];
        }

    }

    public function poll_admin()
    {

        // Login Check

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
                    $this->poll_id = $id;

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
                "poll" => $this->poll_repository->find(["id", $_SESSION["poll_admin"]]),
                "participants" => $this->result_repository->count($this->poll_id)
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


                // Create Answer - Array

                $answers = [];
                $answer_counter = 0;
                foreach ($_POST["answer"] as $answer) {
                    if (isset($_POST["pathfinder"])) {
                        if ($_POST["pathfinder"][$answer_counter] == null) {
                            $temp_answer =
                                [
                                    "answer-content" => $answer,
                                    "type" => "default",
                                    "path" => $_POST["overlapping-path"]
                                ];
                        } else {
                            $temp_answer =
                                [
                                    "answer-content" => $answer,
                                    "type" => "default",
                                    "path" => $_POST["pathfinder"][$answer_counter],
                                    "individual" => true
                                ];
                        }
                    } else {
                        $temp_answer =
                            [
                                "answer-content" => $answer,
                                "type" => "default",
                                "path" => $_POST["overlapping-path"]
                            ];
                    }


                    $answer_counter++;
                    array_push($answers, $temp_answer);
                }

                if ($answer_type === "select+self-filling" || $answer_type === "checkbox+self-filling") {
                    array_push($answers, [
                        "answer-content" => $_POST["fix-answer"],
                        "type" => "self-filling",
                        "path" => $_POST["overlapping-path"]
                    ]);
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


            $last_question = $this->question_repository->last("position");

            $this->render("Admin/Add", [
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

          /*  $questions = [];
            foreach ($questions_db as $question_db)
            {
                $in = false;
                foreach ($questions as $question)
                {
                    if($question["question"]["title"] == $question_db["title"])
                    {
                        $in = true;
                        array_push($question["ids"], $question_db["id"]);

                    }
                }

                if(!$in)
                {
                    array_push($questions, ["question" => $question_db, "ids" => [$question_db["id"]]]);
                }

            }

            print_r($questions[1]);
            die();
*/

            foreach ($questions as $question) {
                $question_results = $this->result_repository->allByQuestion($question["id"]);

                $question_answers = $question["answers"];
                $question_answers = json_decode($question_answers);
                $question_answers = (array)$question_answers;
                $answer_percent = [];

                // Count participants

                $participants_counter = 0;

                if ($question_results) {
                    foreach ($question_results as $result_array) {
                        $participants_counter++;
                    }
                }

                // Calculate percents for answers
                $tempCounter = 0;

                if ($question_results) {

                        $result_array = [];

                        foreach ($question_results as $result) {
                            $is_in = false;
                            $result = (array)$result;
                            $result = explode("#", $result["answer"]);

                            foreach ($result as $res) {
                                if ($question["answer_type"] != "self-filling") {

                                    foreach ($question_answers as $answer) {
                                        $answer = (array)$answer;

                                        if ($answer["answer-content"] == $res) {
                                            $is_in = true;
                                        }
                                    }

                                    if ($is_in) {
                                        $result_array["$res"]["result"] = $res;
                                        if (isset($result_array["$res"]["counter"])) {
                                            $result_array["$res"]["counter"] += 1;
                                        } else {
                                            $result_array["$res"]["counter"] = 1;
                                        }
                                    } else {
                                        if (isset($result_array["other"]["result"])) {
                                            array_push($result_array["other"]["result"], $res);
                                        } else {
                                            if (isset($result_array["other"]["result"])) {
                                                array_push($result_array["other"]["result"], $res);
                                            } else {
                                                $result_array["other"]["result"] = [$res];
                                            }
                                        }

                                        if (!isset($result_array["other"]["other"])) {
                                            $result_array["other"]["other"] = true;
                                        }

                                        if (isset($result_array["other"]["counter"])) {
                                            $result_array["other"]["counter"] += 1;
                                        } else {
                                            $result_array["other"]["counter"] = 1;
                                        }
                                    }
                                }else
                                {
                                    $result_array["$res"]["result"] = $res;
                                    if (isset($result_array["$res"]["counter"])) {
                                        $result_array["$res"]["counter"] += 1;
                                    } else {
                                        $result_array["$res"]["counter"] = 1;
                                    }
                                }

                            }
                        }


                        $result_amount = 0;

                        foreach ($result_array as $result)
                        {
                            $result_amount += $result["counter"];
                        }

                        foreach ($result_array as $result)
                        {
                            if(isset($result["other"]))
                            {
                                $result_array["other"]["percent"] = ($result["counter"] / $result_amount) * 100;
                            }else
                            {
                                $result_array[$result["result"]]["percent"] = ($result["counter"] / $result_amount) * 100;
                            }


                        }

                    array_push(
                        $results,
                        [
                            "question" => $question,
                            "question_results" => (array)$question_results,
                            "participants" => $participants_counter,
                            "result_percent" => $result_array

                        ]);
                } else {
                    array_push(
                        $results,
                        [
                            "question" => $question,
                            "question_results" => (array)$question_results,
                            "participants" => 0,
                            "answer_percent" => false

                        ]
                    );
                }


            }


            $this->render("Admin/Results",
                [
                    "poll" => $this->poll_repository->find(["id", $_SESSION["poll_admin"]]),
                    "results" => $results
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
                if (isset($_POST["overlapping-path"])) {
                    $pathfinder = $_POST["overlapping-path"];
                } else {
                    $pathfinder = $_POST["pathfinder"];
                }
                $path = $_POST["path"];
                if (isset($_POST["finish"])) {
                    $finish = 1;
                } else {
                    $finish = 0;
                }
                if (isset($_POST["optional"])) {
                    $optional = 1;
                } else {
                    $optional = 0;
                }
                $answers = $_POST["answer"];
                $temp_answers = [];
                $temp_counter = 0;
                foreach ($answers as $answer) {
                    if (isset($_POST["pathfinder"])) {
                        array_push($temp_answers, [
                            "answer-content" => $answer,
                            "type" => "default",
                            "path" => $pathfinder[$temp_counter]

                        ]);
                    } else {
                        array_push($temp_answers, [
                            "answer-content" => $answer,
                            "type" => "default",
                            "path" => $pathfinder

                        ]);
                    }

                    $temp_counter++;
                }

                $answers_string = json_encode($temp_answers);

                $this->question_repository->update($id, $title, $content, $answers_string, $position, $path, $optional, $finish);

                $success = "Die Frage mit der ID {$id} wurde erfolgreich aktualisiert";

            }

            $questions = $this->question_repository->allByPosition($_SESSION["poll_admin"]);

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