<?php

    require('../db_init.php');

    $id = $_POST['id'];
    $goal = $_POST['goal'];

    $checkerTable = getCheckerTableById($id);

    $checkerTable['goals'][] = [
        'goal' => $goal,
        'color' => $goalColors[($goalColorPointer++) % count($goalColors)],
        'days' => ['mon' => false, 'tue' => false, 'wed' => false, 'thu' => false, 'fri' => false, 'sat' => false, 'sun' => false]
    ];

    updateCheckerTable($id, $checkerTable);
