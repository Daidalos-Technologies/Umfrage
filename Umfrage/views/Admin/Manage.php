<html>

<head>
    <title>Admin | <?php echo $poll["title"]; ?></title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/admin/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>

        .position {
            display: flex;
            padding: 25px 0;
            justify-content: center;
            text-align: center;
        }

        .question {
            width: 25rem !important;
            max-height: 200px;
            margin-bottom: 20px;
        }

        .path {
            display: inline-block;
            margin: 0 25px;
            text-align: center;

        }

        .path-wrapper {

        }

        .path-header {

            border: 2px solid black;
            width: 25rem;
            padding: 10px 0;
            font-size: 25px;
        }

        .path-content {
            margin-top: 25px;
            text-align: center;
        }

        .new-path-header {
            height: 50px;
            width: 25rem;
            border: 2px solid rgba(128, 128, 128, 0.5);
            color: rgba(128, 128, 128, 0.5);
            font-size: 25px;
            cursor: pointer;
            transition: .3s;
        }

        .new_question {
            margin: 10px 0;
            width: 25rem;
            height: 125px;
            border: 2px solid rgba(128, 128, 128, 0.5);
            font-size: 1.5rem;
            color: rgba(128, 128, 128, 0.5);
            cursor: pointer;
            transition: .3s;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;


        }

        .new_question:hover {
            border-color: white;
            color: white;
            background-color: rgba(128, 128, 128, 0.5);
        }

        .container {


        }


    </style>
</head>

<body>

<?php include __DIR__ . "/../../Elements/header.php"; ?>
<form action="./poll_admin?page=add_question" method="post" id="add-question">
    <input hidden name="position_const" id="position_q">
    <input hidden name="path_const" id="path_q">
</form>
<div class="container">

    <?php $position_ = 0; if (!empty($questions)): ?>
<div class="path-wrapper">
        <?php foreach ($questions as $position => $paths): $position_ = $position; ?>
            <div class="position">
                <?php foreach ($paths as $path_number => $path): ?>
                    <?php if ($path_number == 0): $question = $path["questions"][0];?>
                    <div class="path">
                        <div class="card text-center question">
                            <div class="card-header">
                                <?php echo $question["position"]; ?>. Frage
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Special title treatment</h5>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>

                    <?php else: ?>
                    <div class="path text-center">
                        <div class="path-header">Pfad <b><?php echo $path_number; ?></b></div>
                        <div class="path-content text-center">
                            <?php $question_counter = 0; foreach ($path["questions"] as $question): $question_counter++;?>
                                <div class="card text-center question">
                                    <div class="card-header">
                                        <?php echo $question["position"]; ?>. Frage
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Special title treatment</h5>
                                        <a href="#" class="btn btn-primary">Go somewhere</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="new_question" data-position="<?php echo $question_counter+1; ?>" data-path="<?php echo $path_number; ?>">
                                Frage Hinzufügen
                            </div>
                        </div>
                    </div>

                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if($position != 1): ?>
                    <div class="path">
                        <div class="new_question" data-position="<?php echo $question_counter+1; ?>" data-path="<?php echo $path_number; ?>">
                            Pfad Hinzufügen
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        <?php endforeach; ?>
</div>
        <div class="new_question" style="margin: 0 auto" data-position="<?php echo $position_+1; ?>" data-path="0">
            Neue Frage
        </div>
    <?php else: ?>
        <section class="position">
            <h3>1. Frage</h3>
            <div class="new_question" data-position="1" data-path="0">
                +
            </div>
        </section>

    <?php endif; ?>
</div>
<?php include __DIR__ . "/../../Elements/src.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
<script type="text/javascript">
    $(".new_question").click(function () {
        let position = $(this).attr("data-position");
        let path = $(this).attr("data-path");
        $("#position_q").val(position);
        $("#path_q").val(path);

        $("#add-question").submit();


    })
</script>
</body>
</html>

