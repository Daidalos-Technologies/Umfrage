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
    private $path_repository;
    private $answer_repository;
    private $poll;

    public function __construct($question_repository, $result_repository, $poll_repository, $path_repository, $answer_repository)
    {
        $this->question_repository = $question_repository;
        $this->result_repository = $result_repository;
        $this->poll_repository = $poll_repository;
        $this->path_repository = $path_repository;
        $this->answer_repository = $answer_repository;

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
        } elseif ($_GET["page"] === "manage_questions") {
            $questions = [];

            foreach ($this->path_repository->allByPosition($this->poll_id) as $path) {
                $position = $path["position"];
                $path_number = $path["number"];
                if (isset($questions[$position])) {
                    if (!isset($questions[$position][$path_number])) {
                        $questions[$position][$path_number] = ["path" => $path, "questions" => []];
                    }
                } else {
                    $questions[$position][$path_number] = ["path" => $path, "questions" => []];
                }
            }

            foreach ($this->question_repository->allByPosition($this->poll_id) as $question) {
                $path = $question["path"];
                $path = $this->path_repository->findByPoll(["number", $path], $this->poll_id);

                $is_in = false;

                if($path)
                {
                    array_push($questions[$path["position"]][$path["number"]]["questions"], $question);
                }else
                {
                    $questions[$question["position"]][$question["path"]]["questions"] = [$question];
                }




            }
          /*  foreach ($this->question_repository->allByPosition($this->poll_id) as $question) {
                $position = $question["position"];
                $path = $question["path"];

                if (isset($questions[$position])) {
                    if (isset($questions[$position][$path])) {
                        array_push($questions[$position][$path]["questions"], $question);
                    } else {
                        $questions[$position][$path]["questions"] = [$question];
                    }
                } else {
                    $questions[$position][$path]["questions"] = [$question];
                }
            }*/


            /*foreach ($questions as $position => $position_array) {
                echo "<br><br>";
                echo "<b>Position $position</b>";
                echo "<br><br>";

                foreach ($position_array as $path) {
                    print_r($path);
                    die();
                    $questions_len = sizeof($path["questions"]);
                    echo "Pfad {$path["path"]["number"]} ($questions_len)";
                    echo "<br>";
                }
            }*/

            asort($questions);

            foreach ($questions as $paths){
                asort($paths);
            }

            $this->render("Admin/Manage",
                [
                    "poll" => $this->poll,
                    "questions" => $questions
                ]);
        } else if ($_GET["page"] === "new") {
            if (isset($_POST["position_inp"])) {
                $this->render("Admin/Manage/New", [
                    "position" => $_POST["position_inp"],
                    "poll" => $this->poll
                ]);
            }


        } elseif ($_GET["page"] === "create_path") {

            if (isset($_POST["number"])) {
                $number = $_POST["number"];
                $position = $_POST["position"];

                $this->path_repository->add($number, $position, $this->poll_id);

                header("Location: ./poll_admin?page=manage_questions");
                die();
            }

            $this->render("Admin/Manage/Add_Path", [
                "position" => $_GET["position"],
                "poll" => $this->poll
            ]);

        } elseif ($_GET["page"] === "add_question") {

            if (isset($_POST["title"])) {
                $title = $_POST["title"];
                $content = $_POST["content"];
                $position = $_POST["position"];
                $path = $_POST["path"];
                if (!is_numeric($path)) {
                    $path = 0;
                }
                if(isset($_POST["optional"]))
                {
                    $optional = 1;
                }else
                {
                    $optional = 0;
                }

                if(isset($_POST["finish"]))
                {
                    $finish = 1;
                }else
                {
                    $finish = 0;
                }

                $answers_type = $_POST["answer_type"];

                $new_question_id = $this->question_repository->add($title, $content, $position, $optional, $finish, $path, "", $answers_type, $this->poll_id);

                $answers = $_POST["answers"];

                $answer_ids = [];
                $next_position = $position + 1;
                foreach ($answers as $answer)
                {
                    $answer_id = $this->answer_repository->add($answer, $new_question_id, $next_position, $path);
                    array_push($answer_ids, $answer_id);
                }
                if(isset($_POST["answer-fix"]))
                {
                    $answer_id = $this->answer_repository->add($_POST["answer-fix"], $new_question_id, $next_position, $path);
                }

                $answers_string = implode("#", $answer_ids);
                $this->question_repository->updateSpec($new_question_id, ["answers", $answers_string]);

                header("Location: ./poll_admin?page=manage_questions");
            }

            $this->render("Admin/Manage/Add_Question", [
                "position" => $_POST["position_const"],
                "path" => $_POST["path_const"],
                "poll" => $this->poll
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
            $questions = $this->question_repository->allByPosition($_SESSION["poll_admin"]);

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

            /*   foreach ($questions as $question) {
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


               }*/


            foreach ($questions as $question) {

                $results[$question["position"]]["position"] = $question["position"];
                $results[$question["position"]]["questions"][$question["id"]] = [
                    "question" => $question
                ];

                $question_entry = $results[$question["position"]]["questions"][$question["id"]];


                $question_results = $this->result_repository->allByQuestion($question["id"]);

                // Count participants

                $participants_counter = 0;

                if ($question_results) {
                    foreach ($question_results as $result_array) {
                        $participants_counter++;
                    }
                }

                $question_entry["participants"] = $participants_counter;

                // Get question_answers


                $question_entry["answers"] = [];

                if ($question["answer_type"] != "self-filling") {

                    $question_answers = $question["answers"];
                    $question_answers = json_decode($question_answers);
                    $question_answers = (array)$question_answers;

                    foreach ($question_answers as $answer) {
                        $answer = (array)$answer;
                        if ($answer["type"] != "self-filling") {
                            $question_entry["answers"][$answer["answer-content"]] =
                                [
                                    "answer" => $answer
                                ];
                        }

                    }


                }


                if ($question_results) {
                    $question_entry["results"] = true;

                    foreach ($question_results as $result) {

                        $result = (array)$result;
                        $result = explode("#", $result["answer"]);

                        if ($question["answer_type"] != "self-filling") {

                            foreach ($result as $res) {
                                $is_in = false;

                                if (strlen($res) != 0) {
                                    foreach ($question_entry["answers"] as $answer) {
                                        if (!isset($answer["other"])) {
                                            $answer_content = $answer["answer"]["answer-content"];
                                            if ($answer_content == $res) {
                                                $is_in = $answer;
                                            } else {
                                                $other = $res;
                                            }

                                        }

                                    }
                                }


                                if ($is_in) {

                                    $is_in = $is_in["answer"];

                                    if (isset($question_entry["answers"][$is_in["answer-content"]]["counter"])) {
                                        $question_entry["answers"][$is_in["answer-content"]]["counter"] += 1;
                                    } else {
                                        $question_entry["answers"][$is_in["answer-content"]]["counter"] = 1;
                                    }
                                } else {

                                    if (isset($question_entry["answers"]["other"])) {
                                        array_push($question_entry["answers"]["other"]["answers"], $other);
                                    } else {
                                        $question_entry["answers"]["other"] =
                                            [
                                                "other" => true,
                                                "answers" => [$other]
                                            ];
                                    }

                                }
                            }

                        } else {
                            foreach ($result as $res) {
                                $question_entry["answers"][$res]["content"] = $res;

                                if (isset($question_entry["answers"][$res]["counter"])) {
                                    $question_entry["answers"][$res]["counter"] += 1;
                                } else {
                                    $question_entry["answers"][$res]["counter"] = 1;
                                }
                            }
                        }


                    }

                } else {
                    $question_entry["results"] = false;
                }


                foreach ($question_entry["answers"] as $answer) {

                    if (isset($answer["other"])) {
                        $percent = (sizeof($answer["answers"]) / $participants_counter) * 100;
                        $question_entry["answers"]["other"]["percent"] = $percent;
                    } else {
                        if (!isset($answer["answer"])) {
                            $percent = ($answer["counter"] / $participants_counter) * 100;
                            $question_entry["answers"][$answer["content"]]["percent"] = $percent;

                        } else {

                            if (!isset($answer["counter"])) {
                                $answer_content = $answer["answer"]["answer-content"];
                                $question_entry["answers"][$answer_content]["percent"] = 0;
                            } else {
                                $percent = ($answer["counter"] / $participants_counter) * 100;
                                $answer_content = $answer["answer"]["answer-content"];
                                $question_entry["answers"][$answer_content]["percent"] = $percent;
                            }
                        }

                    }
                }


                $results[$question["position"]]["questions"][$question["id"]] = $question_entry;
            }


            if (isset($_GET["type"])) {
                if ($_GET["type"] == "overview") {
                    echo "currenty not working";
                    die();

                    $this->render("Admin/Results/overview",
                        [
                            "poll" => $this->poll_repository->find(["id", $_SESSION["poll_admin"]]),
                            "results" => $results
                        ]);
                } else if ($_GET["type"] == "path-tree") {
                    $this->render("Admin/Results/path-tree",
                        [
                            "poll" => $this->poll_repository->find(["id", $_SESSION["poll_admin"]]),
                            "results" => $results
                        ]);
                }

            } else {

                $this->render("Admin/Results/path-tree",
                    [
                        "poll" => $this->poll_repository->find(["id", $_SESSION["poll_admin"]]),
                        "results" => $results
                    ]);
            }


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