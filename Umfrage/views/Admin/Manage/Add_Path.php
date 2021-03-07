
<html>

<head>
    <title>Admin| <?php echo $poll["title"]; ?></title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/admin/add.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<?php include __DIR__ . "/../../../Elements/header.php"; ?>
<div class="container mb-5">

    <form class="mt-5" method="post" action="./poll_admin?page=create_path" id="form">
        <div class="form-group">
            <label for="title">Nummer *</label>
            <input class="form-control mt-2" id="number" min="1" type="number" placeholder="Nummer, welche dem Pfad (und später den Fragen) zugewiesen werden soll"
                   name="number" required>
        </div>

        <div class="form-group mt-3">
            <label for="title">Position *</label>
            <input readonly class="form-control mt-2" id="position" min="1" value="<?php echo $position; ?>"
                   name="position" required>
        </div>

        <div class="text-center mt-5">
            <button type="submit" class="btn btn-success">Pfad Erstellen</button>
        </div>
    </form>

</div>

<?php include __DIR__ . "/../../../Elements/src.php"; ?>
<script src="../js/snackbar.js"></script>
<script type="text/javascript">

</script>
</body>
</html>
