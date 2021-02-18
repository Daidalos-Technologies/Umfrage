<html>

<head>
    <title><?php echo $poll["title"]; ?></title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<?php include __DIR__ . "/../../Elements/header.php"; ?>
<div class="container">
    <div class="welcome-text">
        <p class="welcome-text-content">
            <?php echo nl2br($poll["introduction"]); ?>
        </p>
        <div class="d-md-flex justify-content-between align-items-center mt-4">
            <?php if(isset($_COOKIE["finish"])): ?>
            <?php if($_COOKIE["finish"] == $poll["id"] && $admin == false): ?>
                <a class="btn btn-primary" href="./finish.php">Ergebnisse</a>
            <?php else: ?>
                <form action="./umfrage?poll_id=<?php echo $poll["id"]; ?>" method="post">
                    <input hidden name="poll-start" value="1">
                    <button type="submit" class="btn btn-primary">Teilnehmen</button>
                </form>
            <?php endif; ?>
            <?php else: ?>
                <form action="./umfrage?poll_id=<?php echo $poll["id"]; ?>" method="post">
                    <input hidden name="poll-start" value="1">
                    <button type="submit" class="btn btn-primary">Teilnehmen</button>
                </form>
            <?php endif; ?>
            <a class="btn btn-secondary" href="mailto:semiarbeitkryptowaehrung@gmail.com">Kontakt</a>
        </div>

    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
<script type="text/javascript">


</script>
</body>
</html>
