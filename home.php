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



<header>
    <div class="container">
        <h1>Hello, <?= $_SESSION['user']['name'] ?>!</h1>
    </div>
</header>

<main>
    <div class="container">
        <?php
            $editable = true;
            $checkerTable = array_shift($allTables);
            require('checkerTable.php');

            $editable = false;
            foreach ($allTables as $checkerTable) {
                require('checkerTable.php');
            }
        ?>
    </div>
</main>

<!-- <footer></footer> -->
