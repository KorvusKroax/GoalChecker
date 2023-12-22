<?php

    require('../db_init.php');

    $id = $_POST['id'];
    $goal = $_POST['goal'];

    $checkerTable = getCheckerTableById($id);

    $lastColorIndex = end($checkerTable['goals'])['colorIndex'];

    $checkerTable['goals'][] = [
        'goal' => $goal,
        'colorIndex' => ($lastColorIndex + 1) % count($colors),
        'days' => ['mon' => false, 'tue' => false, 'wed' => false, 'thu' => false, 'fri' => false, 'sat' => false, 'sun' => false]
    ];

    updateCheckerTable($id, $checkerTable);
