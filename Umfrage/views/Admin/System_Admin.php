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

<form action="./system_admin" method="post" class="mt-5">
    <h2>Create Poll</h2>
    <input class="form-control mt-3" placeholder="Password" name="poll-password">
    <button class="btn btn-primary mt-3">Submit</button>
</form>

    <table class="table mt-5">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Public</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($polls as $poll): ?>
            <tr>
                <th scope="row"><?php echo $poll["id"]; ?></th>
                <td><?php echo $poll["title"]; ?></td>
                <td><?php echo $poll["public"]; ?></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

</div>
<?php include __DIR__ . "/../../Elements/src.php"; ?>
<script type="text/javascript"></script>
</body>
</html>


