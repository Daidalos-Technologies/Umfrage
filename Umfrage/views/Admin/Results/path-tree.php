<html>

<head>
    <title>Admin | <?php echo $poll["title"]; ?></title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/admin/add.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <style>

        .position {
            padding: 50px 0;
            border-bottom: 1px solid black;
        }

        .question {
            margin: 0 10px;
        }

        .results {
            width: 100%;
        }

        .result {
            height: 50px;
            margin: 10px 0;
            background-color: dodgerblue;
        }

        .result p
        {
            font-weight: bold;
            color: white;
            text-shadow: 1px;
        }

        .other
        {
            cursor: pointer;


        }

    </style>

</head>

<body>

<?php include __DIR__ . "/../../../Elements/header.php"; ?>
<div class="container">

    <div class="text-center mb-5 mt-3">
        <p>Ergebnisanzeige</p>
        <div class="btn-group">
            <a href="./poll_admin?page=results&type=overview" class="btn btn-secondary">Overview</a>
            <a href="./poll_admin?page=results&type=path-tree" class="btn btn-secondary active">Pfad-Baum</a>
            <a href="./poll_admin?page=results&type=user-tree" class="btn btn-secondary">Nach Benutzern</a>

        </div>
    </div>

    <?php foreach ($results as $result): ?>
        <div class="position" id="position-<?php echo $result["position"]; ?>">
            <h2 class="text-center">Position <b><?php echo $result["position"]; ?></b></h2>
            <div class="questions d-flex justify-content-center">
                <?php foreach ($result["questions"] as $question): ?>
                    <div class="card question text-center ">
                        <div class="card-header <?php if($question["question"]["finish"] == 1){echo "bg-danger";} ?>">
                            <b>Pfad <?php echo $question["question"]["path"]; ?></b>
                        </div>
                        <div class="card-body" style="overflow: scroll">
                            <h5 class="card-title"><?php echo $question["question"]["title"]; ?></h5>

                            <div class="results">
                                <?php foreach ($question["answers"] as $answer): ?>
                                    <div class="progress <?php if (isset($answer["other"])){echo "other";} ?>" <?php if (isset($answer["other"])){echo "id='{$question["question"]["id"]}'";} ?>  style="height: 50px">
                                        <div class="progress-bar <?php if (isset($answer["other"])){echo " bg-success";} ?>" role="progressbar" aria-valuenow="<?php echo $answer["percent"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $answer["percent"]; ?>%; ">
                                            <?php if(isset($answer["counter"])): ?>
                                                <?php echo $answer["counter"]; ?>
                                            <?php elseif(isset($answer["other"])): ?>
                                                <?php echo sizeof($answer["answers"]); ?>
                                            <?php else: ?>
                                                <?php echo 0; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if (isset($answer["other"])): ?>

                                        <button hidden type="button" id="button-<?php echo $question["question"]["id"]; ?>" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $question["question"]["id"]; ?>"></button>

                                        <div class="modal fade" id="modal-<?php echo $question["question"]["id"]; ?>"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $question["question"]["title"]; ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4 class="text-center mb-3">Andere Antworten</h4>
                                                        <ul class="list-group list-group-flush">
                                                            <?php foreach ($answer["answers"] as $answ): ?>
                                                                <li class="list-group-item"><?php echo $answ; ?></li>
                                                            <?php endforeach; ?>
                                                        </ul>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="m-1">Andere</p>
                                    <?php else: ?>
                                        <?php if (isset($answer["answer"])): ?>
                                            <p class="m-1"><?php echo $answer["answer"]["answer-content"]; ?></p>
                                        <?php else: ?>
                                            <p class="m-1"><?php echo $answer["content"]; ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                        </div>
                        <div class="card-footer text-muted">
                            Beantwortet von <b><?php echo $question["participants"]; ?></b> Teilnehmern
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    <?php endforeach; ?>


</div>
<?php include __DIR__ . "/../../../Elements/src.php"; ?>
<script type="text/javascript">
$(".other").click(function () {
    let id = $(this).attr("id");
    $("#button-"+id).click();
})
</script>
</body>
</html>


