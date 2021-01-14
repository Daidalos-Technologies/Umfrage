<?php
require "init.php";

if (isset($_POST["answers-amount"])) {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $position = $_POST["position"];
    $jump_to = $_POST["jump_to"];
    $optional = $_POST["optional"];
    $multiple = $_POST["multiple"];
    $jump_on = $_POST["jump_on"];



    $answers_amount = $_POST["answers-amount"];
    $answers = [];

    for ($i = 1; $i <= $answers_amount; $i++) {
        $par = "answer-{$i}";
        array_push($answers, $_POST[$par]);
    }
    $answers_db = "";

    foreach ($answers as $answer) {
        $answers_db = $answers_db . $answer. "#";
    }


    if ($jump_to !== 0) {
        $statement = $pdo->prepare("INSERT INTO poll (title, content, answers, position, jump, jump_to, optional, multiple_choice, jump_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $statement->execute(array($title, $content, $answers_db, $position, 1, $jump_to, $optional, $multiple, $jump_on));
    } else {
        $statement = $pdo->prepare("INSERT INTO poll (title, content, answers, position, optional, multiple_choice, jump_on) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $statement->execute(array($title, $content, $answers_db, $position, $optional, $multiple, $jump_on));
    }


}

$questions = fetch_all("poll");


?>

<html>
<head>
    <title>Admin | Kryptowährung</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">

    <style>
        .answers input {
            margin-top: 1rem;
        }
    </style>
</head>

<body>
<div class="container mt-5">
    <form class="form" action="admin.php" method="post">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Question-Title *</label>
            <input type="text" name="title" class="form-control" id="exampleFormControlInput1" required>
        </div>
        <div class="mb-3">
            <label for="position" class="form-label">Question-Position *</label>
            <input type="number" name="position" class="form-control" id="position" required>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Question-Content</label>
            <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="jump_to" class="form-label">Jump_To *</label>
            <input type="number" name="jump_to" id="jump_to" class="form-control" value="0" required>
        </div>
        <div class="mb-3">
            <label for="jump_on" class="form-label">Jump_On *</label>
            <input type="number" name="jump_on" id="jump_on" class="form-control" value="0" required>
        </div>
        <div class="mb-3">
            <label for="optional" class="form-label">Optional *</label>
            <input type="number" name="optional" id="optional" class="form-control" value="0" required>
        </div>
        <div class="mb-3">
            <label for="multiple" class="form-label">Multiple *</label>
            <input type="number" name="multiple" id="multiple" class="form-control" value="0" required>
        </div>
        <div class="answers">
            <input hidden id="answers-amount" name="answers-amount" value="1">
            <input class="form-control" name="answer-1" placeholder="answer-1 *" required>
        </div>
        <button type="button" class="btn btn-outline-secondary mt-3" id="new_answer">+</button>
        <button type="button" class="btn btn-outline-secondary mt-3" style="display: none" id="delete_new_answer">-
        </button>
        <br>
        <button class="mt-3 btn btn-primary" type="submit">Submit</button>
    </form>

    <div class="questions mt-5">
        <?php
        foreach ($questions as $question):
            ?>
            <div class="question-preview">
                <div class="row d-flex h-100 align-items-center">
                    <div class="col-4"><?php echo $question["position"]; ?></div>
                    <div class="col-8"><?php echo $question["title"]; ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>

<script type="text/javascript">

    $("#new_answer").click(function () {
        let answers_amount = parseInt($("#answers-amount").val());
        answers_amount++;
        console.log(answers_amount);
        $("#answers-amount").val(answers_amount);
        if (answers_amount >= 2) {
            $("#delete_new_answer").fadeIn();
        }
        let new_answer = $("<input />").addClass("form-control").appendTo(".answers").attr({
            "placeholder": "answer-" + answers_amount + " *",
            "name": "answer-" + answers_amount,
            "required": true
        });

    });

    $("#delete_new_answer").click(function () {
        let answers_amount = parseInt($("#answers-amount").val());
        answers_amount--;
        console.log(answers_amount);
        if (answers_amount <= 1) {
            $("#delete_new_answer").fadeOut();
        }
        $("#answers-amount").val(answers_amount);
        $(".answers input").last().remove();
    })
</script>
</body>
</html>
