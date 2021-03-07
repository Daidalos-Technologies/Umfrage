
<html>

<head>
    <title>Admin| <?php echo $poll["title"]; ?></title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/admin/add.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<?php include __DIR__ . "/../../../Elements/header.php"; ?>
<div class="container mb-5">

    <form class="mt-5" method="post" action="./poll_admin?page=add_question" id="form">
        <input hidden name="answer-counter" value="1" id="answer-counter">
        <div class="form-group">
            <label for="title">Titel *</label>
            <input class="form-control mt-2" id="title" placeholder="z.B. Wie sehr mögen Sie die Farbe blau..."
                   name="title" required>
        </div>

        <div class="form-group mt-3">
            <label for="title">Zusatzinformationen </label>
            <textarea class="form-control mt-2" name="content" id="content"
                      placeholder="z.B. Es gibt 16,7 Millionen Farben im RGB-Farbraum..."></textarea>
        </div>

        <div class="form-group mt-3" id="select-wrapper">
            <label for="position">Position *</label>
           <input class="form-control mt-2" readonly name="position" value="<?php echo $position ?>">
        </div>

        <div class="form-group mt-3" id="select-wrapper">
            <label for="position">Pfad *</label>
            <?php if($path != 0): ?>
            <input class="form-control mt-2" readonly name="path" value="<?php echo $path ?>">
            <?php else: ?>
                <input class="form-control mt-2" name="path" readonly value="Standard Pfad">
            <?php endif; ?>
        </div>

        <div class="form-group mt-3">
            <div class="form-check form-switch">
                <input class="form-check-input" name="optional" type="checkbox" id="optional">
                <label class="form-check-label" for="optional">Optionale Frage</label>
            </div>
        </div>

        <div class="form-group mt-3">
            <div class="form-check form-switch">
                <input class="form-check-input" name="finish" type="checkbox" id="finish">
                <label class="form-check-label" for="finish">Beendet Umfrage</label>
            </div>
        </div>

        <div class="form-group mt-3" id="select-wrapper">
            <label for="answer-type">Typ der Antworten *</label>
            <select class="form-select mt-2" name="answer_type" id="answer-type" aria-label="Default select example">
                <option value="select" selected>Mehrere Antwortmöglichkeiten - nur eine Antwort</option>
                <option value="checkbox">Mehrere Antworten Möglich</option>
                <option value="self-filling">Individuelle Antwort</option>
                <option value="select+self-filling">Mehrere Antwortmöglichkeiten - nur eine Antwort + Individuelle
                    Antwort
                </option>
                <option value="checkbox+self-filling">Mehrere Antworten Möglich + Individuelle Antwort</option>
            </select>
        </div>
        <div id="overlapping-wrapper">

        </div>
        <div class="answer-wrapper">
            <div id="answers" class="mt-3">
                <label>Antwortmöglichkeiten *</label>


            </div>
            <button type="button" class="btn btn-secondary mt-2" id="add-answer">+</button>
            <button type="button" class="btn btn-secondary mt-2" id="remove-answer">-</button>
            <div id="fix-answer">

            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-primary mt-3">Absenden</button>
        </div>

    </form>

</div>

<?php include __DIR__ . "/../../../Elements/src.php"; ?>
<script src="../js/snackbar.js"></script>
<script type="text/javascript">
    let answer_counter = 1;
    $(document).ready(function () {
        $("<input />").addClass("form-control mt-2").attr({name: "answers[]", placeholder: "Antwortmöglichkeit "+answer_counter, required: true, id: answer_counter}).appendTo("#answers");
    })

    document.getElementById("answer-type").addEventListener("change", function () {
        let option = this.selectedOptions[0].value;
        $("#answers input").remove();
        $("#fix-answer input").remove();
        answer_counter = 1;
        if(option == "select" || option == "checkbox")
        {
            $("<input />").addClass("form-control mt-2").attr({name: "answers[]", placeholder: "Antwortmöglichkeit "+answer_counter, required: true, id: answer_counter}).appendTo("#answers");
        }else if(option == "checkbox+self-filling" || option == "select+self-filling")
        {
            $("<input />").addClass("form-control mt-2").attr({name: "answers[]", placeholder: "Antwortmöglichkeit "+answer_counter, required: true, id: answer_counter}).appendTo("#answers");
            $("<input />").addClass("form-control mt-4").attr({name: "answer-fix", placeholder: "Platzhalter für Individuelle Antwort", required: true}).appendTo("#fix-answer");
        }

    });

    $("#add-answer").click(function () {
        answer_counter++;
        $("<input />").addClass("form-control mt-2").attr({name: "answers[]", placeholder: "Antwortmöglichkeit "+answer_counter, required: true, id: answer_counter}).appendTo("#answers");
    })
    $("#remove-answer").click(function () {
        if(answer_counter > 1)
        {
            $("#"+answer_counter).remove();
            answer_counter--;
        }
    })
</script>
</body>
</html>
