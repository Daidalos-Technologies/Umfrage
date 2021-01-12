<?php
session_start();
if(!isset($_SESSION["result_id"])){
    $hash = md5(time());
    $_SESSION["result_id"] = $hash;
}

require "init.php";


if(isset($_POST["poll_id"]))
{

    

$old_poll = fetch_by_id($_POST["poll_id"]);
if($old_poll["jump"] === 0) {
    $next_poll = $old_poll["jump_to"];
}else {
    $next_poll = $old_poll["position"] + 1;
}

$poll = fetch_by_position($next_poll);

}else {
    $poll = fetch_by_position(1);
}

$poll_answers = explode("#", $poll["answers"]);


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
                    <form class="answers mt-5 text-left" method="post" action="./umfrage.php">
                        <input hidden name="poll_id" value="<?php echo $poll["id"]; ?>">
                        <select class="form-select" aria-label="Default select example" name="answer">
                            <?php $counter = 0;
                            foreach ($poll_answers as $answer): $counter++; ?>
                                <?php if ($counter === 1): ?>
                                    <option value="<?php echo $answer; ?>" selected><?php echo $answer; ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $answer; ?>"><?php echo $answer; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary mt-4">Weiter</button>
                    </form>

                </div>
                <div class="card-footer text-muted">
                    <?php echo $poll["position"]; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>


</div>
</body>
</html>