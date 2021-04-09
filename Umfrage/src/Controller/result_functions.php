<?php
function get_results_by_question($question_repository, $result_repository, $poll_id)
{

    $results = [];
    $questions = $question_repository->allByPoll($poll_id);
    foreach ($questions as $question)
    {

        $results[$question["position"]]["position"] = $question["position"];
        $results[$question["position"]]["questions"][$question["id"]] = [
            "question" => $question
        ];

        $question_entry = $results[$question["position"]]["questions"][$question["id"]];

        $question_results = $result_repository->allByQuestion($question["id"]);

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

        if($question["answer_type"] != "self-filling")
        {

            $question_answers = $question["answers"];
            $question_answers = json_decode($question_answers);
            $question_answers = (array)$question_answers;

            foreach ($question_answers as $answer)
            {
                $answer = (array)$answer;
                if($answer["type"] != "self-filling")
                {
                    $question_entry["answers"][$answer["answer-content"]] =
                        [
                            "answer" => $answer
                        ];
                }

            }


        }


        if($question_results)
        {
            $question_entry["results"] = true;

            foreach ($question_results as $result)
            {

                $result = (array)$result;
                $result = explode("#", $result["answer"]);

                if($question["answer_type"] != "self-filling")
                {

                    foreach ($result as $res)
                    {
                        $is_in = false;

                        if(strlen($res) != 0){
                            foreach ($question_entry["answers"] as $answer)
                            {
                                if(!isset($answer["other"])){
                                    $answer_content = $answer["answer"]["answer-content"];
                                    if($answer_content == $res)
                                    {
                                        $is_in = $answer;
                                    }else
                                    {
                                        $other = $res;
                                    }

                                }

                            }
                        }



                        if($is_in)
                        {

                            $is_in = $is_in["answer"];

                            if(isset($question_entry["answers"][$is_in["answer-content"]]["counter"]))
                            {
                                $question_entry["answers"][$is_in["answer-content"]]["counter"] += 1;
                            }else
                            {
                                $question_entry["answers"][$is_in["answer-content"]]["counter"] = 1;
                            }
                        }else
                        {

                            if(isset($question_entry["answers"]["other"]))
                            {
                                array_push( $question_entry["answers"]["other"]["answers"], $other);
                            }else
                            {
                                $question_entry["answers"]["other"] =
                                    [
                                        "other" => true,
                                        "answers" => [$other]
                                    ];
                            }

                        }
                    }

                }else
                {
                    foreach ($result as $res)
                    {
                        $question_entry["answers"][$res]["content"] = $res;

                        if(isset($question_entry["answers"][$res]["counter"]))
                        {
                            $question_entry["answers"][$res]["counter"] += 1;
                        }else
                        {
                            $question_entry["answers"][$res]["counter"] = 1;
                        }
                    }
                }


            }

        }else
        {
            $question_entry["results"] = false;
        }


        foreach ($question_entry["answers"] as $answer)
        {

            if(isset($answer["other"]))
            {
                $percent = (sizeof($answer["answers"]) / $participants_counter) * 100;
                $question_entry["answers"]["other"]["percent"] = $percent;
            }else
            {
                if(!isset($answer["answer"]))
                {
                    $percent = ($answer["counter"] / $participants_counter) * 100;
                    $question_entry["answers"][$answer["content"]]["percent"] = $percent;

                }else
                {

                    if(!isset($answer["counter"]))
                    {
                        $answer_content = $answer["answer"]["answer-content"];
                        $question_entry["answers"][$answer_content]["percent"] = 0;
                    }else
                    {
                        $percent = ($answer["counter"] / $participants_counter) * 100;
                        $answer_content = $answer["answer"]["answer-content"];
                        $question_entry["answers"][$answer_content]["percent"] = $percent;
                    }
                }

            }
        }


        $results[$question["position"]]["questions"][$question["id"]] = $question_entry;
    }

    return $results;
}

function get_results_by_user($question_repository, $result_repository, $poll_id)
{

    // get all users

    $users = [];

    $results = $result_repository->allByPoll($poll_id);

    foreach ($results as $result)
    {
        $user_id = $result["user_id"];

        if(!array_search($user_id, $users))
        {
            array_push($users, $user_id);
        }
    }

    // create user arrays

    $user_data = [];

    foreach ($users as $user_id)
    {
        $user_results_db = $result_repository->allByUser($user_id, $poll_id);

        $user_results = [];

        foreach ($user_results_db as $user_result)
        {
            $user_result = (array)$user_result;
            array_push($user_results,
            [
                "result" => $user_result,
                "question" => $question_repository->find(["id", $user_result["question_id"]])
            ]);
        }


        array_push($user_data,
        [
            "user_id" => $user_id,
            "results" => $user_results
        ]);
    }

    return $user_data;

}

/*function remove_not_finished ($controller)
{
    $finish_array = [];

    foreach ($controller->question_repository->allByPoll($controller->poll_id) as $question)
    {
        if($question["finish"] == 1)
        {
            array_push($finish_array, $question["id"]);
        }
    }

    foreach ($controller->result_repository->allByPollNotFinish($controller->poll_id) as $result)
    {

        foreach ($finish_array as $question_id)
        {
            if($result["question_id"] == $question_id)
            {
                $controller->result_repository->updateFinish($result["user_id"]);
            }
        }

    }
}
*/
function remove_not_started ($controller)
{
    $start_array = [];

    foreach ($controller->question_repository->allByPoll($controller->poll_id) as $question)
    {
        if($question["position"] == 1)
        {
            array_push($start_array, $question["id"]);
        }
    }


    $checked_users = [];

    foreach ($controller->result_repository->allByPoll($controller->poll_id) as $result)
    {

        if(!array_search($result["user_id"], $checked_users))
        {
            array_push($checked_users, $result["user_id"]);
            $is_in = false;
            foreach ($controller->result_repository->allByUser($result["user_id"], $controller->poll_id) as $user_result)
            {
                $user_result = (array)$user_result;
                if(array_search($user_result["question_id"], $start_array) !== false)
                {
                    $is_in = true;
                }
            }

            if(!$is_in)
            {
                echo "update:".$result["user_id"]."<br>";
                $controller->result_repository->updateFinishToNull($result["user_id"]);
            }
        }

    }
}