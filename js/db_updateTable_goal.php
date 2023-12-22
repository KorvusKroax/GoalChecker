<?php

    require('../db_init.php');

    $id = $_POST['id'];
    $row = $_POST['row'];
    $goal = $_POST['goal'];

    $checkerTable = getCheckerTableById($id);

    $checkerTable['goals'][$row]['goal'] = $goal;

    updateCheckerTable($id, $checkerTable);
