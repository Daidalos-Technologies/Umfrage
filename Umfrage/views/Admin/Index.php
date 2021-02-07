<html>

<head>
    <title>Admin| Kryptowährung</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/admin/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<?php include __DIR__ . "/../../Elements/header.php"; ?>
<div class="container">

    <h1 class="text-center mt-5">Admin-Bereich</h1>
    <?php if($poll["public"] == 1): ?>
        <p class="text-center text-success">Umfrage ist öffentlich!</p>
    <?php else: ?>
        <p class="text-center text-danger">Umfrage ist nicht öffentlich!</p>
    <?php endif; ?>
    <input readonly class="form-control" value="smartpoll.antonhauffe.de/umfrage?poll_id=<?php echo $poll["id"]; ?>">

<div class="menu">
    <a href="./poll_admin?page=add_questions" class="menu-item btn btn-primary" ><div class="d-flex justify-content-center align-items-center h-100 w-100">Fragen Hinzufügen</div></a>
    <a class="menu-item btn btn-Warning"><div class="d-flex justify-content-center align-items-center h-100 w-100">Fragen Bearbeiten/Löschen</div></a>
    <a href="./poll_admin?page=settings" class="menu-item btn btn-secondary"><div class="d-flex justify-content-center align-items-center h-100 w-100">Einstellungen</div></a>
    <a class="menu-item btn btn-success"><div class="d-flex justify-content-center align-items-center h-100 w-100">Ergebnisse</div></a>

</div>

    <form class="text-center" action="./poll_admin" method="post">
        <input hidden name="logout" value="1">
        <button class="btn btn-danger btn-lg">Logout</button>
    </form>

</div>
<?php include __DIR__ . "/../../Elements/src.php"; ?>
<script type="text/javascript"></script>
</body>
</html>
