<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Korvus">

        <link rel="icon" href="img/favicon.png">

        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/form.css">
        <link rel="stylesheet" href="css/input.css">
        <link rel="stylesheet" href="css/button.css">
        <link rel="stylesheet" href="css/table.css">
        <link rel="stylesheet" href="css/checkbox.css">

        <script src="js/updateTable.js" defer></script>
        <script src="js/editTable.js" defer></script>

        <title>GoalChecker</title>
    </head>
    <body>
        <header>
            <div class="container small">
                <?php if (isset($_SESSION["user"])) : ?>
                    <div class="inline-full">
                        <h1>Hello, <?= $_SESSION['user']['name'] ?>!</h1>
                        <button onClick="location.href='logout.php'">Kilépés</button>
                    </div>
                <?php else : ?>
                    <h1><?= $headerText ?></h1>
                <?php endif; ?>
            </div>
        </header>

        <?php
            if (isset($_SESSION['error'])) {
                echo '<br><span class="error">' . $_SESSION['error'] . '</span>';
                unset($_SESSION['error']);
            }
        ?>
