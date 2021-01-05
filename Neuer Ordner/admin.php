<?php
require "init.php";

?>

<html>
<head>
    <title>Admin | Kryptowährung</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
</head>

<body>
<div class="container mt-5">
    <form class="form" action="admin.php">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Question-Title</label>
            <input type="text" class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Question-Content</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <div class="answers">
            <input hidden id="answers-amount" name="answers-amount" value="1">
            <input class="form-control" name="answer-1" placeholder="answer-1">
        </div>
        <button type="button" class="btn btn-outline-secondary mt-3" id="new_answer">+</button>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

<script type="text/javascript">
$("#new_answer").click(function () {
    let answers_amount = parseInt($("#answers-amount").val());
    answers_amount++;
    console.log(answers_amount);
    $("#answers-amount").val(answers_amount);
    $("<input />").addClass("form-control").appendTo(".answers").attr("placeholder", "answer-"+answers_amount);

})
</script>
</body>
</html>
