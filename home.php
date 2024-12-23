<?php

    $date = date('Y. F/W');
    $today = strtolower(date('D'));

    $allTables = getAllCheckerTables();

    if ($allTables[0]['caption'] != $date) {
        createNewTableBasedOnLastTable($date);
        $allTables = getAllCheckerTables();
    }
?>



<?php require('header.php'); ?>

<main>
    <div class="container">

        <?php
            $editable = true;
            $checkerTable = $allTables[0];
            require('checkerNote.php');
        ?>

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

<?php require('footer.php'); ?>
