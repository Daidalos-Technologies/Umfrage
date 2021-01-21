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

$questions = fetch_all("questions");


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
            <input type="number" name="position" class="form-control" id="position" value="<?php $last_question = end($questions); echo $last_question["position"] + 1; ?>" required>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Question-Content</label>
            <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="optional" class="form-label">Optional *</label>
            <br>
            <input type="checkbox" name="optional" id="optional">
        </div>
        <div class="mb-3">
            <label for="optional" class="form-label">Erschließungsfrage *</label>
            <br>
            <input type="checkbox" name="special" id="optional">
        </div>
        <div class="answers">
            <input hidden id="answers-amount" name="answers-amount" value="0">
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

    let answers = [];

    class Answer
    {
        constructor(number, next_pos) {
            this.number = number;

            this.$_answerRow = $("<div />").addClass("row align-items-end").appendTo(".answers");
            let $_col6 = $("<div />").addClass("col-6").appendTo(this.$_answerRow);
            let $_col3_2 = $("<div />").addClass("col-3").appendTo(this.$_answerRow);
            let $_col3 = $("<div />").addClass("col-3").appendTo(this.$_answerRow);

            let $_answer = $("<input />").addClass("form-control").attr({
                "name": "answer-"+this.number,
                "placeholder": "answer-"+this.number,
                "required": true
            }).appendTo($_col6);

            let $_nextPosition = $("<input />").addClass("form-control").attr({
                "name": "next-position-"+this.number,
                "placeholder": "next-question",
                "required": true,
                "type": "number"
            }).val(next_pos+1).appendTo($_col3);

            let $_type = $("<select />").addClass("form-select").attr({
                "name": "type-"+this.number,
                "required": true
            }).append(
                "<option value='select' selected>Select</option>" +
                "<option value='self-filling'>Self-Filling</option>" +
                "<option value='checkbox'>Checkbox</option>"
            ).appendTo($_col3_2);


        }

        delete()
        {
            this.$_answerRow.remove()
        }
    }

    $("#new_answer").click(() => {
        let answers_amount = parseInt($("#answers-amount").val());
        answers_amount++;
        $("#answers-amount").val(answers_amount);
        if (answers_amount >= 2) {
            $("#delete_new_answer").fadeIn();
        }
        answers.push(new Answer(answers_amount, <?php echo $last_question["position"] + 1;?>));

    });
    $("#new_answer").click();

    $("#delete_new_answer").click( () => {
        let answers_amount = parseInt($("#answers-amount").val());
        answers_amount--;
        console.log(answers_amount);
        if (answers_amount <= 1) {
            $("#delete_new_answer").fadeOut();
        }
        $("#answers-amount").val(answers_amount);
        let pos = answers.length - 1;
       answers[pos].delete();
       answers.pop();
    })
</script>
</body>
</html>
