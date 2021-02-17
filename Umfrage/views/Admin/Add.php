<?php
$path_question = false;
if(isset($last_question))
{
    if($last_question["path"] != 0)
    {
        $path_question = true;
    }
}




?>

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

<?php include __DIR__ . "/../../Elements/header.php"; ?>
<div class="container mb-5">
    <?php if ($last_question != false): ?>
        <div class="last-question-wrapper text-center mt-5">
            <h3>Letzte Frage</h3>
            <p class="text-secondary text-center mt-2"><?php echo $last_question["title"]; ?></p>
        </div>
    <?php endif; ?>
    <form class="mt-5" method="post" action="./poll_admin?page=add_questions" id="form">
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
            <select class="form-select mt-2" name="position" id="position" aria-label="Default select example">
                <?php if ($last_question == 0): ?>
                    <option value="1">Erste Frage (1)</option>
                <?php else: ?>

                    <option value="<?php echo $last_question["position"] + 1; ?>">Nach letzer Frage
                        <b>(<?php echo $last_question["position"] + 1; ?>)</b></option>
                <?php endif; ?>
                <?php if($path_question): ?>
                    <option value="<?php echo $last_question["position"]; ?>" selected>Mit letztem Pfad zusammen
                        <b>(<?php echo $last_question["position"]; ?>)</b></option>
                <?php endif; ?>
                <option value="self-filling">Individuelle Position</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <div class="form-check form-switch">
                <input class="form-check-input" name="optional" type="checkbox" id="optional">
                <label class="form-check-label" for="optional">Optionale Frage</label>
            </div>
        </div>


        <div class="form-group mt-3" id="path-wrapper">
            <div class="form-check form-switch">
                <input class="form-check-input" name="path-question" type="checkbox" id="path-question" <?php if($path_question){echo "checked";} ?>>
                <label class="form-check-label" for="path-question">Verschachtelte Frage</label>
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
            <select class="form-select mt-2" name="answer-type" id="answer-type" aria-label="Default select example">
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
            <div id="fix-answer">

            </div>
            <button type="button" class="btn btn-secondary mt-2" id="add-answer">+</button>
            <button type="button" class="btn btn-secondary mt-2" id="remove-answer">-</button>
        </div>
        <div class="text-center">
            <button class="btn btn-primary mt-3">Absenden</button>
        </div>

    </form>

    <?php if (isset($error)): ?>
        <?php if ($error == false): ?>
            <div style="padding: 0 20%" class="mt-5">
                <div class="alert alert-success text-center" role="alert">
                    Frage erfolgreich hinzugefügt
                </div>
            </div>
        <?php else: ?>
            <div style="padding: 0 20%" class="mt-5">
                <div class="alert alert-danger text-center" role="alert">
                    <?php echo $error; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif;
    ?>

</div>

<?php include __DIR__ . "/../../Elements/src.php"; ?>
<script src="../js/snackbar.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        if ($("#answer-type").val() == "select") {
            answers.push(new Answer(1, true));
        } else if ($("#answer-type").val() == "self-filling") {
            $(".answer-wrapper").css("display", "none");
            $("#answers input").val("false");
        } else {
            answers.push(new Answer(1, false));
        }
        $("<input name='overlapping-path' id='overlapping-path' class='form-control mt-2 mb-3' placeholder='Übergreifender Pfad'/>").appendTo("#overlapping-wrapper");

        $("body,html").animate(
            {
                scrollTop: $("#form").offset().top
            },
            800 //speed
        );

        <?php if($path_question): ?>
        $("<input />").addClass("form-control mt-2 w-25").attr({
            "name": "path",
            "required": true,
            "placeholder": "Pfad",
            "type": "number",
            "id": "path"
        }).appendTo("#path-wrapper");
        <?php endif; ?>

    });
    let position_select = document.getElementById("position");
    position_select.addEventListener("change", function () {
        if (this.value === "self-filling") {
            let sel_input = $("<input />").addClass("form-control w-25 mt-2").attr({
                "required": true,
                "placeholder": "Position",
                "id": "select-input",
                "type": "number",
                "name": "individual-position"
            }).appendTo("#select-wrapper");

        } else {
            $("#select-input").remove();

        }
    });

    document.getElementById("answer-type").addEventListener("change", function () {
        answers.forEach((answer) => {
            console.log("test")
            answer.delete();
            console.log(answer + " deleted")
        });
        counter = 1;
        $("#overlapping-path").remove();

        if ($("#answer-type").val() == "select") {
            answers.push(new Answer(counter, true));

        } else {
            if ($("#answer-type").val() == "select+self-filling" || $("#answer-type").val() == "checkbox+self-filling") {
                $("#fix-answer input").remove();

                $("<input />").addClass("form-control mt-2").attr({
                    "name": "fix-answer",
                    "required": true,
                    "placeholder": "Platzhalter für Individuelle Antwort"
                }).appendTo("#fix-answer");
            } else {
                $("#fix-answer input").remove();
            }
            answers.push(new Answer(counter, false));
            $("<input name='overlapping-path' id='overlapping-path' class='form-control mt-2 mb-3' placeholder='Übergreifender Pfad'/>").appendTo("#overlapping-wrapper");
        }

        if (this.value === "self-filling") {
            $(".answer-wrapper").css("display", "none");
            $("#answers input").val("false");
        } else {
            $(".answer-wrapper").css("display", "block");
            $("#answers input").val("");
            $("body,html").animate(
                {
                    scrollTop: $("#answers").offset().top
                },
                800
            );
        }
    });

    class Answer {
        constructor(counter, path) {
            this.counter = counter;
            if (path == true) {
                this.$_el = $("<div />").addClass("row mt-2").appendTo("#answers");
                this.$_col8 = $("<div />").addClass("col-8").appendTo(this.$_el);
                this.$_col4 = $("<div />").addClass("col-4").appendTo(this.$_el);
                this.$_answer = $("<input />").addClass("form-control").attr({
                    "placeholder": "Antwortmöglichkeit " + counter,
                    "required": true,
                    "name": "answer[]"
                }).appendTo(this.$_col8);
                this.$_pathFinder = $("<input />").addClass("form-control").attr({
                    "placeholder": "Individueller Pfad",
                    "name": "pathfinder[]",
                    type: "number"
                }).appendTo(this.$_col4);
            } else {
                this.$_el = $("<div />").addClass("row mt-2").appendTo("#answers");
                this.$_col12 = $("<div />").addClass("col-12").appendTo(this.$_el);
                this.$_answer = $("<input />").addClass("form-control").attr({
                    "placeholder": "Antwortmöglichkeit " + counter,
                    "required": true,
                    "name": "answer[]"
                }).appendTo(this.$_col12);
            }

        }

        delete() {
            this.$_el.remove();
        }
    }

    let counter = 1;
    let answers = [];
    $("#add-answer").click(function () {
        counter++;
        $("#answer-counter").val(counter);
        if ($("#answer-type").val() == "select") {
            answers.push(new Answer(counter, true));
        } else {
            answers.push(new Answer(counter, false));
        }

        $("body,html").animate(
            {
                scrollTop: $("#answers").offset().top
            },
            800
        );
    })
    $("#remove-answer").click(function () {
        if (counter !== 1) {
            counter--;
            answers[answers.length - 1].delete();
            answers.pop();
            $("body,html").animate(
                {
                    scrollTop: $("#answers").offset().top
                },
                800
            );
        }

    });

    document.getElementById("path-question").addEventListener("change", function () {
        if (this.checked == true) {
            $("<input />").addClass("form-control mt-2 w-25").attr({
                "name": "path",
                "required": true,
                "placeholder": "Pfad",
                "type": "number",
                "id": "path"
            }).appendTo("#path-wrapper");
        } else {
            $("#path").remove();
        }
    })
</script>
</body>
</html>
