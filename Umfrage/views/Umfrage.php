<html>

<head>
    <title>Umfrage | Kryptowährung</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<?php include __DIR__."/../Elements/header.php"; ?>
<div class="container">
        <div class="poll-container">
            <div class="card text-center">
                <div class="card-header">
                    Umfrage - Kryptowährung
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $question["title"]; ?></h5>
                    <p class="card-text"><?php echo $question["content"]; ?></p>
                    <form class="answers mt-5 text-left" method="post" id="form" action="./umfrage.php">
                        <input hidden name="poll_id" value="<?php echo $question["id"]; ?>">
                        <input hidden name="skip" id="skip_inp">

                            <input name="answer" type="number" class="form-control" required>

                            <select class="form-select" aria-label="Default select example" name="answer" required>
                                <option disabled selected hidden style="background-color: grey !important">---</option> <!-- TODO: add grey background-color -->
                                    <option value=""</option>
                            </select>
                                <div class="form-check text-left">
                                    <input name="answer[]" class="form-check-input" type="checkbox" value="" id="answer-">
                                    <label class="form-check-label" for="answer-">
                                    </label>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button type="button" class="btn btn-secondary" id="skip">Überspringen</button>
                                <button type="submit" class="btn btn-primary">Weiter</button>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4">Weiter</button>
                    </form>

                </div>
                <div class="card-footer text-muted">
                </div>
            </div>
        </div>


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
