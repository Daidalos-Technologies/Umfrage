<?php
require "init.php";

?>

<html>

<head>
    <title>Umfrage | Kryptowährung</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="loading.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php include "header.php"; ?>

<div class="container">
    <div class="welcome-text">
        <p class="welcome-text-content">
        Guten Tag,

        wir sind eine Gruppe von fünf Schülern in der 11. Klasse der Staatlichen Gemeinschaftsschule Jenaplan in Weimar und müssen, im Rahmen der Oberstufe, eine Seminarfacharbeit, also eine erste wissenschaftliche Arbeit, ablegen.<br><br>
        In unserer Arbeit beschäftigen wir uns mit dem Thema “Kryptowährung” und ob es möglich ist, eine “konventionelle Währung” durch eine Kryptowährung zu ersetzen.

        Mit Hilfe dieses Fragebogens möchten wir Ihre Meinung zu dem Thema “Kryptowährung” erfragen.
        Damit unsere Umfrage repräsentativ werden kann, müssen wir Sie in den ersten Fragen nach ein paar persönlichen Daten fragen. Wir wären Ihnen sehr verbunden, wenn Sie uns diese Informationen nicht vorenthalten würden.<br><br>
        Falls Sie Fragen haben, dann erreichen uns unter der unten stehenden E-Mail-Adresse.

        Vielen Dank, dass Sie sich Zeit nehmen, diesen Fragebogen auszufüllen und uns damit bei unserer Arbeit zu unterstützen.

        </p>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <?php if(isset($_COOKIE["finish"])): ?>
                <a class="btn btn-primary" href="./finish.php">Ergebnisse</a>
            <?php else: ?>
            <a class="btn btn-primary" href="./umfrage.php">Teilnehmen</a>
            <?php endif; ?>
            <a class="btn btn-secondary" href="mailto:semiarbeitkryptowaehrung@gmail.com">Kontakt</a>
        </div>

    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>

<script src="loading.js"></script>
</body>

</html>
