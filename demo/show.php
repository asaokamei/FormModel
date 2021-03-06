<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/builder.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $book = buildForm();
    $html = $book->createView();
} else {
    $book = buildForm();
    $validation = $book->createValidation($_POST);
    $html = $validation->createView();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>demo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="demo.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<div class="header">
    <div class="container">
        <h1>Sample Form</h1>
        <p class="text-muted">This sample uses Bootstrap 4 and jQuery. </p>
    </div>
</div>

<div class="container">

    <?php if (isset($validation)) : ?>
        <?php
        if ($validation->isValid()) {
            echo '<div class="alert alert-success">Verified!</div>';
        } else {
            echo '<div class="alert alert-danger">Please check the input values!!!</div>';
        }
        ?>
    <?php endif; ?>

    <form id="sample-form" action="" method="post" novalidate="">

        <?= $html->show(); ?>

        <p class="text-info"><label><input type="checkbox" onclick="toggleValidation(this);"> turn on html validation.</label></p>
        <script>
            function toggleValidation(check) {
                let form = document.getElementById('sample-form');
                form.noValidate = !$(check).is(':checked');
            }
        </script>

        <input type="submit" value="validate input!" class="btn btn-primary">
    </form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>

</div>
</body>
</html>

