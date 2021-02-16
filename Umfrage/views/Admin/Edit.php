<html>

<head>
    <title>Admin | <?php echo $poll["title"]; ?></title>
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

    <?php if (isset($success)): ?>
        <?php if ($success): ?>
            <div class="alert mt-3 alert-success" role="alert">
               <?php echo $success; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
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
                <?php if ($question["path"] == 0): ?>
                    <th scope="row"><?php echo $question["position"]; ?></th>
                <?php else: ?>
                    <th scope="row"><?php echo "{$question['position']}.{$question['path']}"; ?></th>
                <?php endif; ?>
                <td><?php echo $question["title"]; ?></td>
                <td class="row">

                    <form class="col-6" action="./poll_admin?page=edit" method="post"><input hidden name="delete"
                                                                                             value="<?php echo $question["id"]; ?>">
                        <button class="btn btn-danger">Löschen</button>
                    </form>
                    <form class="col-6" action="./poll_admin?page=edit" method="post"><input hidden name="edit-id"
                                                                                             value="<?php echo $question["id"]; ?>">
                        <button class="btn btn-warning">Bearbeiten</button>
                    </form>

                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

</div>

<?php if (isset($edit_question)): ?>
    <!-- Button trigger modal -->
    <button hidden type="button" id="activate-edit-modal" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Frage Bearbeiten</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" action="./poll_admin?page=edit" method="post">
                    <input hidden name="edit" value="1">
                    <div class="form-group">
                        <label for="title">ID *</label>
                        <input readonly value="<?php echo $edit_question['id']; ?>" class="form-control mt-2" id="id"
                               name="id">
                    </div>
                    <div class="form-group mt-3">
                        <label for="title">Titel *</label>
                        <input class="form-control mt-2" id="title" value="<?php echo $edit_question['title']; ?>"
                               name="title" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="title">Zusatzinformationen </label>
                        <textarea class="form-control mt-2" name="content"
                                  id="content"><?php echo $edit_question['content']; ?></textarea>
                    </div>

                    <div class="form-group mt-3" id="select-wrapper">
                        <label for="position">Position *</label>
                        <input class="form-control mt-2" id="title" value="<?php echo $edit_question['position']; ?>"
                               name="position" required>
                        <label for="position">Pfad *</label>
                        <input class="form-control mt-2" id="title" value="<?php echo $edit_question['path']; ?>"
                               name="path" required>
                    </div>

                    <div class="form-group mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="optional" type="checkbox"
                                   id="optional" <?php if ($edit_question["optional"] == 1) {
                                echo "checked";
                            }; ?>>
                            <label class="form-check-label" for="optional">Optionale Frage</label>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="finish" type="checkbox"
                                   id="finish" <?php if ($edit_question["finish"] == 1) {
                                echo "checked";
                            }; ?>>
                            <label class="form-check-label" for="finish">Beendet Umfrage</label>
                        </div>
                    </div>
                    <?php if($edit_question["answer_type"] != "select"): ?>
                    <div class="form-group mt-3">
                        <label class="form-check-label" for="">Übergreifender Pfad</label>
                        <input name="overlapping-path" value="<?php $temp_answer = (array)$answers[0]; echo $temp_answer["path"]; ?>" class="form-control mt-2">
                    </div>
                    <?php endif; ?>
                    <div class="answer-wrapper   <?php if($edit_question["answer_type"] == "self-filling"){echo "d-none";} ?>">
                        <div id="answers" class="mt-3">
                            <label>Antwortmöglichkeiten *</label>
                            <?php $counter = 0;
                            foreach ($answers as $answer): $answer = (array)$answer;
                                $counter++; ?>
                                <?php if ($edit_question['answer_type'] == "select"): ?>
                                    <input hidden id="answer-type" value="select">
                                    <div class="row mt-2">
                                        <div class="col-8">
                                            <input class="form-control" name="answer[]"
                                                   value="<?php echo $answer["answer-content"]; ?>" required>
                                        </div>
                                        <div class="col-4">
                                            <input class="form-control" value="<?php echo $answer["path"]; ?>"
                                                   type="number"
                                                   name="pathfinder[]">
                                        </div>
                                    </div>

                                <?php else: ?>
                                    <input hidden id="answer-type" value="false">
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <input class="form-control" name="answer[]"
                                                   value="<?php echo $answer["answer-content"]; ?>" required>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </div>
                        <button type="button" class="btn btn-secondary mt-2" id="add-answer">+</button>
                        <button type="button" class="btn btn-secondary mt-2" id="remove-answer">-</button>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary mt-3">Absenden</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php include __DIR__ . "/../../Elements/src.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
<script type="text/javascript">
    $("#activate-edit-modal").click();

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
                    "placeholder": "Pfad",
                    "name": "pathfinder[]",
                    type: "number"
                }).appendTo(this.$_col4);
            } else {
                this.$_el = $("<div />").addClass("row mt-2").appendTo("#answers");
                this.$_col12 = $("<div />").addClass("col-12").appendTo(this.$_el);
                this.$_answer = $("<input />").addClass("form-control").attr({
                    "placeholder": "Antwortmöglichkeit " + counter,
                    "required": true,
                    "name": "answer´[]"
                }).appendTo(this.$_col12);
            }

        }

        delete() {
            this.$_el.remove();
        }
    }

    let counter = <?php echo $counter; ?>;
    let answers = [];
    $("#add-answer").click(function () {
        counter++;
        $("#answer-counter").val(counter);
        if ($("#answer-type").val() == "select") {
            answers.push(new Answer(counter, true));
        } else {
            answers.push(new Answer(counter, false));
        }


    })
    $("#remove-answer").click(function () {
        if (counter !== 1) {
            counter--;
            answers[answers.length - 1].delete();
            answers.pop();
        }

    });
</script>
</body>
</html>

