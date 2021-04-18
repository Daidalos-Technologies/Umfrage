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


        .card
        {
            margin: 0 25px;
        }

        #user-nav
        {
            position: fixed;
            z-index: 1;
            left: 0;
            right: 0;
            top: 35%;

            text-align: center;
        }

        #user-nav a
        {
            margin: 5px 0;
            text-align: center;
            text-decoration: none;
            display: inline-block;
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

    <div id="user-nav" class="d-none">
        <?php $user_counter = 0; foreach ($results as $user_results): $user_counter++;?>
        <a class="btn btn-primary" href="#user-<?php echo $user_results["user_id"]; ?>"><?php echo $user_counter; ?>. Eintrag</a>
        <?php endforeach; ?>
    </div>

    <?php $user_counter = 0; foreach ($results as $user_results):  $user_counter++;?>
        <div id="user-<?php echo $user_results["user_id"]; ?>" class="card mt-3 mb-3 text-center">
            <div class="card-header">
                <b>User_ID:</b> <?php echo $user_results["user_id"]; ?>
            </div>
            <div class="card-body">
                <button class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo$user_results["results"][0]["result"]["id"]; ?>" role="button" aria-expanded="false" aria-controls="collapse-<?php echo $user_results["results"][0]["result"]["id"]; ?>">Anzeigen</button>
                <div class="collapse mt-3" id="collapse-<?php echo $user_results["results"][0]["result"]["id"]; ?>">
                    <div class="card card-body">
                        <?php foreach ($questions as $position): ?>
                            <div class="pt-5 pb-5">
                                <h4>Position <?php echo $position["position"]; ?></h4>
                                <div class="d-flex justify-content-center">

                                <?php foreach ($position["questions"] as $question): $is_in = false; $question = (array)$question[0];?>
                                <?php foreach ($results[$user_results["user_id"]]["results"] as $result): ?>
                                    <?php if($result["question"] == $question["id"]): $is_in = true; ?>
                                            <div class="card bg-success text-white text-center">
                                                <div class="card-header">
                                                    <?php echo $question["title"]; ?>
                                                </div>
                                                <div class="card-body">
                                                    <?php  $result_ = explode("#", $result["result"]["answer"]);
                                                    foreach ($result_ as $res):
                                                    ?>
                                                        <p><?php echo $res; ?></p>
                                                    <?php endforeach; ?>
                                                </div>

                                            </div>
                                    <?php endif; ?>
                                <?php endforeach;
                                if(!$is_in):
                                ?>
                                    <div class="card text-center bg-secondary text-white" disabled>
                                        <div class="card-header">
                                            <?php echo $question["title"]; ?>
                                        </div>

                                    </div>
                                <?php endif; endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <button class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo$user_results["results"][0]["result"]["id"]; ?>" role="button" aria-expanded="false" aria-controls="collapse-<?php echo $user_results["results"][0]["result"]["id"]; ?>">Schließen</button>
                    </div>
                </div>
            </div>
            <div class=" card-footer">
                <?php echo $user_counter; ?>. Eintrag
            </div>
        </div>
    <?php endforeach; ?>
<div class="d-flex justify-content-center">
    <nav style="margin: 3rem auto" aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="./poll_admin?page=results&type=user-tree&site=<?php if($_GET["site"] != 1){echo $_GET['site']-1;}else{echo 1;}  ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php $max_pages = 0; for ($i = 1; $i <= $pages; $i++): $max_pages = $i; ?>
                <li class="page-item"><a class="page-link" href="./poll_admin?page=results&type=user-tree&site=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
            <li class="page-item">
                <a class="page-link" href="./poll_admin?page=results&type=user-tree&site=<?php if($_GET["site"] != $max_pages){echo $_GET['site']+1;}else{echo $max_pages;}  ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
</div>
<?php include __DIR__ . "/../../../Elements/src.php"; ?>
<script type="text/javascript">

</script>
</body>
</html>


