<?php

    require('../db_init.php');

    $id = $_POST['id'];
    $row = $_POST['row'];

    $checkerTable = getCheckerTableById($id);

    unset($checkerTable['goals'][$row]);

    updateCheckerTable($id, $checkerTable);
