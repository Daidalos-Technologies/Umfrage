<?php
require "init.php";
setcookie("finish", $_SESSION["result_id"], time()+(3600*24*365));


$results= fetch_all_by_user_id($_SESSION["result_id"]);
?>

<html>

<head>
    <title>Umfrage | Kryptowährung</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="loading.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        h1 {
            font-family: 'Roboto', sans-serif;
            font-weight: 300;
        }

        .results-wrapper
        {
            padding: 25px;
            border: 1px solid black;
        }

        .result
        {
            padding: 15px;
        }
    </style>
</head>
<body>
<?php include "header.php"; ?>

<div class="container">
   <h1 class="text-center mt-5">Vielen Dank, dass Sie an unserer Umfrage Teilgenommen haben!</h1>
    <div class="results-wrapper mt-5">
        <h2 class="text-center">Ihre Antworten</h2>
        <div class="results mt-5">
        <?php foreach ($results as $result):
            $poll = fetch_by_id($result["poll_id"]);
            ?>
            <div class="result">
                <div class="row">
                    <div class="col-8">
                        <b>
                        <?php echo $poll["title"]; ?>
                        </b>
                    </div>
                    <div class="col-4">
                        <?php echo $result["answer"]; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="text-center">
        <a href="./index.php" class="btn btn-primary mt-5">Zurück zur Hauptseite</a>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>

<script src="loading.js"></script>
</body>

</html>

