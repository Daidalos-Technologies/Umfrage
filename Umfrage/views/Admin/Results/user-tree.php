<html>

<head>
    <title>Admin | <?php echo $poll["title"]; ?></title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/admin/add.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <style>

        .position {
            padding: 50px 0;
            border-bottom: 1px solid black;
        }

        .question {
            margin: 0 10px;
        }

        .results {
            width: 100%;
        }

        .result {
            height: 50px;
            margin: 10px 0;
            background-color: dodgerblue;
        }

        .result p
        {
            font-weight: bold;
            color: white;
            text-shadow: 1px;
        }

        .other
        {
            cursor: pointer;


        }

    </style>

</head>

<body>

<?php include __DIR__ . "/../../../Elements/header.php"; ?>
<div class="container">

    <div class="text-center mb-5 mt-3">
        <p>Ergebnisanzeige</p>
        <div class="btn-group">
            <a href="./poll_admin?page=results&type=overview" class="btn btn-secondary">Overview</a>
            <a href="./poll_admin?page=results&type=path-tree" class="btn btn-secondary ">Pfad-Baum</a>
            <a href="./poll_admin?page=results&type=user-tree" class="btn btn-secondary active">Nach Benutzern</a>

        </div>
    </div>

    <?php foreach ($results as $user_results): ?>
        <div class="card text-center">
            <div class="card-header">
                Featured
            </div>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
            <div class="card-footer text-muted">
                2 days ago
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php include __DIR__ . "/../../../Elements/src.php"; ?>
<script type="text/javascript">

</script>
</body>
</html>


