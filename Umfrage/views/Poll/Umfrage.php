<html>

<head>
    <title><?php echo $poll["title"]; ?></title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<?php include __DIR__ . "/../../Elements/header.php"; ?>
<div class="container">
        <div class="poll-container">
            <div class="card">
                <div class="card-header text-center">
                    Umfrage - Kryptowährung
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center"><?php echo $question["title"]; ?></h5>
                    <p class="card-text text-center"><?php echo $question["content"]; ?></p>
                    <form class="answers mt-5 text-left" method="post" id="form" action="./umfrage?poll_id=<?php echo $poll['id']; ?>">
                        <input hidden name="question-id" value="<?php echo $question["id"]; ?>">
                        <input hidden name="next-path" value="0" id="next-path">
                        <div id="answers">
                    <?php if($question["answer_type"] === "select"): ?>
                    <div class="text-center">
                        <select class="form-select answer" aria-label="Default select example" name="answer" required">
                            <option disabled selected hidden style="background-color: grey !important">---</option>
                            <?php foreach ($answers as $answer): $answer = (array)$answer;?>
                                <option data-path="<?php echo $answer["path"]; ?>" value="<?php echo $answer["answer-content"]; ?>"><?php echo $answer["answer-content"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                        <?php elseif ($question["answer_type"] === "checkbox"): ?>
                        <?php foreach ($answers as $answer): $answer = (array)$answer;?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" value="<?php echo $answer["answer-content"]; ?>" name="answer[]" type="checkbox" >
                                <label class="form-check-label" ><?php echo $answer["answer-content"];  ?></label>
                            </div>
                        <?php endforeach; ?>
                        <?php elseif ($question["answer_type"] === "self-filling"): ?>
                        <?php foreach ($answers as $answer): $answer = (array)$answer;?>
                        <div class="text-center">
                            <input class="form-control" id="answer" name="answer" required>
                        </div>
                        <?php endforeach; ?>
                        <?php elseif ($question["answer_type"] === "select+self-filling"): ?>
                    <div class="text-center">
                        <select class="form-select answer" aria-label="Default select example" name="answer" required>
                            <option disabled selected hidden style="background-color: grey !important">---</option>
                            <?php foreach ($answers as $answer): $answer = (array)$answer;?>
                                <?php if($answer["type"] == "self-filling"): ?>
                                    <option id="activate-self-filling" data-path="<?php echo $answer["path"]; ?>" value="self-filling"><?php echo $answer["answer-content"]; ?></option>
                                <?php else: ?>
                                    <option data-path="<?php echo $answer["path"]; ?>" value="<?php echo $answer["answer-content"]; ?>"><?php echo $answer["answer-content"]; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                        <?php elseif ($question["answer_type"] === "checkbox+self-filling"): ?>
                        <?php foreach ($answers as $answer): $answer = (array)$answer;?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" value="<?php echo $answer["answer-content"]; ?>" name="answer[]" type="checkbox" >
                                <label class="form-check-label" ><?php echo $answer["answer-content"];  ?></label>
                            </div>
                        <?php endforeach; ?>
                    <input class="form-control mt-2" name="answer[]" placeholder="Eigene Antwort...">
                        <?php endif; ?>
                        </div>
                        <?php if($question["optional"] === 1): ?>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button type="button" class="btn btn-secondary" id="skip">Überspringen</button>
                                <button type="submit" id="submit" class="btn btn-primary">Weiter</button>
                            </div>
                        <?php else: ?>
                        <div class="text-center">
                            <button type="submit" id="submit" class="btn btn-primary mt-4">Weiter</button>
                        </div>

                        <?php endif; ?>

                    </form>

                   <form method="post" id="skip-form" action="./umfrage?poll_id=<?php echo $poll["id"]; ?>">
                       <input hidden name="skip" value="1">
                       <?php
                       if($question["answer_type"] != "select")
                       {
                           $temp_answer = (array)$answers[0];
                            echo "<input hidden name='overlapping-path' value='{$temp_answer['path']}' >";
                       }
                       ?>
                       <input hidden name="question-id" value="<?php echo $question["id"]; ?>">
                   </form>

                </div>
                <div class="card-footer text-muted text-center">
                    <?php
                    if($question["path"] !== 0)
                    {
                        echo "{$question["position"]}.{$question["path"]}";
                    }else
                    {
                        echo $question["position"];
                    }
                    ?>
                </div>
            </div>
        </div>


</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
<script type="text/javascript">

    $(document).ready(function () {
        <?php if($question["answer_type"] != "select"): ?>
        $("#next-path").val(<?php $temp_answer = (array)$answers[0]; echo $temp_answer["path"]; ?>)
        <?php endif; ?>
    })

    $("#skip").click(function () {
       $("#skip-form").submit();
    });

    $("#answer option").click(function () {
      $("#next-path").val(this.getAttribute("data-path"));
    });

    $("#answer option").click(function () {
        console.log(this);
        if(this.getAttribute("id") == "activate-self-filling")
        {
            $("<input />").addClass("form-control mt-3").attr({"required": true, "name": "self-answer", "id": "self-answer", "placeholder": "Deine Antwort..."}).appendTo("#answers");
        }else
        {
            $("#self-answer").remove();
        }
    })



</script>
</body>
</html>
