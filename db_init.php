<?php

    define('DB_DRIVER','mysql');
    define('DB_NAME','checker');
    // define('DB_HOST','mysql80.r3.websupport.hu');
    // define('DB_PORT','3314');
    // define('DB_USER','vr69qz86');
    // define('DB_PASSWORD','Hd1r-X}}Nd');
    define('DB_HOST','localhost');
    define('DB_PORT','');
    define('DB_USER','root');
    define('DB_PASSWORD','');

    require('db_functions.php');

    $weekDays = ['mon' => 'H', 'tue' => 'K', 'wed' => 'SZ', 'thu' => 'CS', 'fri' => 'P', 'sat' => 'SZ', 'sun' => 'V'];

    $colors = ['#CC99C9', '#9EC1CF', '#9EE09E', '#FDFD97', '#FEB144', '#FF6663'];



    if (!isDatabaseExists()) createDatabase();

    if (!isTableExists('checker_tables')) createCheckerTablesTable();

    if (empty(getAllCheckerTables())) {
        $lastColorIndex = 0;
        addCheckerTable([
            'caption' => date('Y. F/W'),
            'goals' => [
                [
                    'goal' => 'első napi cél',
                    'colorIndex' => ($lastColorIndex++) % count($colors),
                    'days' => ['mon' => false, 'tue' => false, 'wed' => false, 'thu' => false, 'fri' => false, 'sat' => false, 'sun' => false]
                ],
                [
                    'goal' => 'második napi cél',
                    'colorIndex' => ($lastColorIndex++) % count($colors),
                    'days' => ['mon' => false, 'tue' => false, 'wed' => false, 'thu' => false, 'fri' => false, 'sat' => false, 'sun' => false]
                ],
                [
                    'goal' => 'sokadik napi cél',
                    'colorIndex' => ($lastColorIndex++) % count($colors),
                    'days' => ['mon' => false, 'tue' => false, 'wed' => false, 'thu' => false, 'fri' => false, 'sat' => false, 'sun' => false]
                ]
            ]
        ]);
    }
