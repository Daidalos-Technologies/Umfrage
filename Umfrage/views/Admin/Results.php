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
        .results {
            width: 100%;
            padding: 10px 0px;
            border-left: 5px solid black;
            margin: 50px 0;
        }

        .result-wrapper {
            margin: 25px 0;
        }

        .result {
            height: 50px;
            background-color: dodgerblue;

        }
    </style>

</head>

<body>

<?php include __DIR__ . "/../../Elements/header.php"; ?>
<div class="container">


    <?php foreach ($results as $result): ?>
        <div class="results">
            <h3 class="m-2"><?php echo $result["question"]["title"]; ?></h3>
            <?php if (isset($result["result_percent"])): ?>
                <?php foreach ($result["result_percent"] as $answer): ?>
                    <?php if (!isset($answer["other"])): ?>
                        <div class="result-wrapper">
                            <div class="result d-flex align-items-center"
                                 style="width: <?php echo $answer["percent"]; ?>%"><p
                                        class="text-light"><?php echo $answer["counter"]; ?></p></div>
                            <label class="m-2"><?php echo $answer["result"]; ?></label>
                        </div>
                    <?php else: ?>
                        <div class="result-wrapper">
                            <div class="result d-flex align-items-center"
                                 style="width: <?php echo $answer["percent"]; ?>%"><p
                                        class="text-light"><?php echo $answer["counter"]; ?></p></div>
                            <label class="m-1">Anderer Grund</label>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>


</div>
<?php include __DIR__ . "/../../Elements/src.php"; ?>
<script type="text/javascript">

</script>
</body>
</html>

