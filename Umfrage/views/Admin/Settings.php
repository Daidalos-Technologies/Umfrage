<html>

<head>
    <title>Admin| Kryptowährung</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/admin/add.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<?php include __DIR__ . "/../../Elements/header.php"; ?>
<div class="container mb-5">

    <h1 class="text-center mt-5" >Einstellungen</h1>

    <form class="mt-5" action="./poll_admin?page=settings" method="post">
        <div class="form-group">
            <label>ID</label>
            <input readonly name="id" class="form-control mt-2" value="<?php echo $poll["id"]; ?>">
        </div>
        <div class="form-group mt-3">
            <label>Titel *</label>
            <input class="form-control mt-2" value="<?php echo $poll["title"]; ?>" name="title" required>
        </div>

        <div class="form-group mt-3">
            <label>Einleitung *</label>
            <textarea class="form-control mt-2" rows="10" name="introduction" required><?php echo $poll["introduction"]; ?></textarea>
        </div>

        <div class="form-group mt-3">
            <label>Dankestext *</label>
            <textarea class="form-control mt-2" rows="5" name="outroduction" required><?php echo $poll["outroduction"]; ?></textarea>
        </div>

        <div class="text-center">
            <button class="btn btn-primary mt-3">Absenden</button>
        </div>

        <?php if(isset($success)): ?>
        <div style="padding: 0 20%" class="mt-5">
            <div class="alert alert-success text-center" role="alert">
                Umfrage erfolgreich aktualisiert!
            </div>
        </div>
        <?php endif; ?>

    </form>

</div>

<?php include __DIR__ . "/../../Elements/src.php"; ?>
<script src="../js/snackbar.js"></script>
<script type="text/javascript">

</script>
</body>
</html>
