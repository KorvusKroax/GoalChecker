<?php
    require('db_init.php');

    $date = date('Y. F/W');
    $today = strtolower(date('D'));

    $allTables = getAllCheckerTables();

    if ($allTables[0]['caption'] != $date) {
        createNewTableBasedOnLastTable($date);
        $allTables = getAllCheckerTables();
    }
?>



<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Korvus">

        <link rel="stylesheet" href="css/main.css">
        <!-- <link rel="stylesheet" href="css/footer_to_bottom.css"> -->
        <link rel="stylesheet" href="css/table.css">
        <link rel="stylesheet" href="css/checkbox.css">
        <link rel="stylesheet" href="css/button.css">

        <script src="js/updateTable.js" defer></script>

        <title>GoalChecker</title>
    </head>
    <body>
        <header></header>

        <main>
            <div class="container">
                <?php
                    foreach ($allTables as $checkerTable) {
                        require('checkerTable.php');
                    }
                ?>
            </div>
        </main>

        <footer></footer>
    </body>
</html>
