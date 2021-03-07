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
            padding: 25px 0;
            justify-content: space-around;
            text-align: center;
        }

        .question {
            margin: 10px;
            width: 25rem !important;
            max-height: 200px;
        }

        .path {
            display: inline-block;
            margin: 0 25px;
            text-align: center;

        }

        .path-wrapper {
            display: flex;
        }

        .path-header {
            height: 50px;
            width: 100%;
            border: 2px solid black;
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
            margin: 10px;
            width: 25rem !important;
            height: 125px;
            border: 2px solid rgba(128, 128, 128, 0.5);
            font-size: 67.5px;
            color: rgba(128, 128, 128, 0.5);
            cursor: pointer;
            transition: .3s;

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

    <?php if (!empty($questions)): ?>

    <?php foreach ($questions as $position => $position_array): ?>
    <section class="position ">
        <h3><?php echo $position; ?>. Frage</h3>
        <div class="path-wrapper m-5">

            <?php foreach ($position_array as $path => $path_obj): ?>
                <?php if ($path == 0): ?>
                <div class="path">
                    <div class="path-header">
                        Standard Pfad
                    </div>

                    <?php foreach ($path_obj["questions"] as $question): ?>
                        <div class="path-content">
                            <div class="card question">
                                <div class="card-header">Position <?php echo $question["position"]; ?></div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $question["title"]; ?></h5>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                   
                </div>
                <?php else: ?>
                    <div class="path">
                        <div class="path-header">
                            Pfad <?php echo $path["path"]["number"]; ?>
                        </div>
                    </div>
                <?php endif; ?>

            <?php endforeach; ?>
            <div class="path">
                <div class="new-path-header">
                    +
                </div>
            </div>
        </div>
    </section>
<?php endforeach; ?>

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

