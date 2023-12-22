<?php

    require('../db_init.php');

    $id = $_POST['id'];
    $row = $_POST['row'];
    $day = $_POST['day'];

    $checkerTable = getCheckerTableById($id);

    $checkerTable['goals'][$row]['days'][$day] = !$checkerTable['goals'][$row]['days'][$day];

    updateCheckerTable($id, $checkerTable);
