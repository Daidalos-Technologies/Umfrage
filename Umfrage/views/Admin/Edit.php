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

    <table class="table mt-5">
        <thead>
        <tr>
            <th scope="col">Position</th>
            <th scope="col">Titel</th>
            <th scope="col">Aktionen</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($questions as $question): ?>
            <tr>
                <?php if($question["path"] == 0): ?>
                <th scope="row"><?php echo $question["position"]; ?></th>
                <?php else: ?>
                    <th scope="row"><?php echo "{$question['position']}.{$question['path']}"; ?></th>
                <?php endif; ?>
                <td><?php echo $question["title"]; ?></td>
                <td><form action="./poll_admin?page=edit" method="post"><input hidden name="delete" value="<?php echo $question["id"]; ?>"><button class="btn btn-danger">Löschen</button> </form> </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

</div>
<?php include __DIR__ . "/../../Elements/src.php"; ?>
<script type="text/javascript"></script>
</body>
</html>

