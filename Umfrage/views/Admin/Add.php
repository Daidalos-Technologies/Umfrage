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
<div class="container">

    <form class="mt-5">
        <div class="form-group">
            <label for="title">Titel *</label>
            <input class="form-control mt-2" id="title" placeholder="z.B. Wie sehr mögen Sie die Farbe blau..." name="title" required>
        </div>

        <div class="form-group mt-3">
            <label for="title">Zusatzinformationen </label>
            <textarea class="form-control mt-2" id="content" placeholder="z.B. Wie sehr mögen Sie die Farbe blau..."></textarea>
        </div>

    </form>

</div>
<?php include __DIR__ . "/../../Elements/src.php"; ?>
<script type="text/javascript"></script>
</body>
</html>
