<?php
session_start();
if (!isset($_SESSION["result_id"])) {
    $hash = md5(time());
    $_SESSION["result_id"] = $hash;
}

require "init.php";


if (isset($_POST["poll_id"])) {


    $old_poll = fetch_by_id($_POST["poll_id"]);
    $old_position = $old_poll["position"];

    $result = fetch_result_by_user_id($_SESSION["result_id"], $old_poll["id"]);

    if ($_POST["skip"] != 1) {
        if ($result == false) {
            add_result($_SESSION["result_id"], $old_poll["id"], $_POST["answer"]);
        } else {
            update_result($_SESSION["result_id"], $old_poll["id"], $_POST["answer"]);
        }
    }

    if ($old_poll["jump"] === 0) {
        $next_poll = $old_poll["jump_to"];
    } else {
        $next_poll = $old_poll["position"] + 1;
    }

    $poll = fetch_by_position($next_poll);

} else {
    $poll = fetch_by_position(1);
}

if($poll["answers"] === "self-filling") {
    $poll_answers = "self-filling";
}else {
    $poll_answers = explode("#", $poll["answers"]);
}



?>

<html>

<head>
    <title>Umfrage | Kryptowährung</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
</head>

<body>

<header></header>
<div class="container">
    <?php if ($poll !== false): ?>
        <div class="poll-container">
            <div class="card text-center">
                <div class="card-header">
                    Umfrage - Kryptowährung
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $poll["title"]; ?></h5>
                    <p class="card-text"><?php echo $poll["content"]; ?></p>
                    <form class="answers mt-5 text-left" method="post" id="form" action="./umfrage.php">
                        <input hidden name="poll_id" value="<?php echo $poll["id"]; ?>">
                        <input hidden name="skip" id="skip_inp">
                        <?php if($poll_answers === "self-filling"): ?>
                            <input name="answer" class="form-control" required>
                        <?php else: ?>
                        <select class="form-select" aria-label="Default select example" name="answer" required>
                            <option disabled selected hidden style="background-color: grey !important">---</option> <!-- TODO: add grey background-color -->
                            <?php $counter = 0;
                            foreach ($poll_answers as $answer): $counter++; ?>
                                <option value="<?php echo $answer; ?>"><?php echo $answer; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php endif; ?>
                        <?php if ($poll["optional"] == 1): ?>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button type="button" class="btn btn-secondary" id="skip">Überspringen</button>
                                <button type="submit" class="btn btn-primary">Weiter</button>
                            </div>
                        <?php else: ?>
                            <button type="submit" class="btn btn-primary mt-4">Weiter</button>
                        <?php endif; ?>
                    </form>

                </div>
                <div class="card-footer text-muted">
                    <?php echo $poll["position"]; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>


</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
<script type="text/javascript">

    $("#skip").click(function () {
        $("#skip_inp").val("1");
        $("#form").submit();
    })

</script>
</body>
</html>
