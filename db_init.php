<?php

    define("DB_DRIVER", "mysql");
    define("DB_NAME", "checkers");
    // define("DB_HOST", "optometeroptika.hu");
    // define("DB_USER", "vr69qz86");
    // define("DB_PASSWORD", "Hd1r-X}}Nd");
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASSWORD", "");

    require('db_functions.php');

    $weekDays = ['mon' => 'H', 'tue' => 'K', 'wed' => 'SZ', 'thu' => 'CS', 'fri' => 'P', 'sat' => 'SZ', 'sun' => 'V'];

    $goalColors = ['#CC99C9', '#9EC1CF', '#9EE09E', '#FDFD97', '#FEB144', '#FF6663'];
    $goalColorPointer = 0;



    if (!isDatabaseExists()) createDatabase();

    if (!isTableExists("checker_tables")) createCheckerTablesTable();

    if (empty(getAllCheckerTables())) {
        addCheckerTable([
            'caption' => date('Y. F/W'),
            'goals' => [
                [
                    'goal' => 'első napi cél',
                    'color' => $goalColors[($goalColorPointer++) % count($goalColors)],
                    'days' => ['mon' => false, 'tue' => false, 'wed' => false, 'thu' => false, 'fri' => false, 'sat' => false, 'sun' => false]
                ],
                [
                    'goal' => 'második napi cél',
                    'color' => $goalColors[($goalColorPointer++) % count($goalColors)],
                    'days' => ['mon' => false, 'tue' => false, 'wed' => false, 'thu' => false, 'fri' => false, 'sat' => false, 'sun' => false]
                ],
                [
                    'goal' => 'sokadik napi cél',
                    'color' => $goalColors[($goalColorPointer++) % count($goalColors)],
                    'days' => ['mon' => false, 'tue' => false, 'wed' => false, 'thu' => false, 'fri' => false, 'sat' => false, 'sun' => false]
                ]
            ]
        ]);
    }
