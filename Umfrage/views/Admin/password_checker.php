<html>

<head>
    <title>SystemAdmin| Kryptowährung</title>
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

    <?php if(isset($poll_admin)): ?>
    <div class="text-center" style="padding: 10% 20%">
        <form action="./poll_admin" method="post">
            <input class="form-control" type="number" name="id" placeholder="Umfragen-ID" required>
            <input class="form-control mt-3" type="password" name="password" placeholder="Passwort" required>
            <button class="btn btn-primary mt-3" type="submit">Submit</button>
        </form>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center w-50" style="margin: 0 auto" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
    </div>


    <?php else: ?>
    <div class="text-center" style="padding: 10% 20%">
        <form action="./system_admin" method="post">
            <input class="form-control" type="password" name="password" placeholder="Password" required>
            <button class="btn btn-primary mt-3" type="submit">Submit</button>
        </form>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center w-50" style="margin: 0 auto" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
    </div>

<?php endif; ?>
</div>
<?php include __DIR__ . "/../../Elements/src.php"; ?>
<script type="text/javascript"></script>
</body>
</html>

