
<html>

<head>
    <title>Admin| <?php echo $poll["title"]; ?></title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/admin/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<?php include __DIR__ . "/../../../Elements/header.php"; ?>
<div class="container mb-5">

    <div class="menu">
        <a class="menu-item btn btn-primary">
            <div class="d-flex justify-content-center align-items-center h-100 w-100">Frage Hinzufügen</div>
        </a>
        <a href="./poll_admin?page=create_path&position=<?php echo $position; ?>" class="menu-item btn btn-success">
            <div class="d-flex justify-content-center align-items-center h-100 w-100">Pfad Erstellen</div>
        </a>
    </div>

</div>
<?php include __DIR__ . "/../../../Elements/src.php"; ?>
<script src="../js/snackbar.js"></script>
<script type="text/javascript">

</script>
</body>
</html>
