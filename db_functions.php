<?php

    function isDatabaseExists()
    {
        $con = new PDO(DB_DRIVER . ":hostname=" . DB_HOST, DB_USER, DB_PASSWORD);
        $result = $con->query('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "' . DB_NAME . '"');
        return (bool) $result->fetchColumn();
    }

    function createDatabase()
    {
        $con = new PDO(DB_DRIVER . ":hostname=" . DB_HOST, DB_USER, DB_PASSWORD);
        $con->exec('CREATE DATABASE ' . DB_NAME);
    }

    function dbQuery($query, $data = array())
    {
        $con = new PDO(DB_DRIVER . ":hostname=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        if ($stm = $con->prepare($query)) {
            if ($stm->execute($data)) {
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                if (is_array($result) && count($result) > 0) {
                    return $result;
                }
            }
        }
        return $con->lastInsertId();
    }

    function isTableExists($tablename)
    {
        return dbQuery(
            'SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = "' . DB_NAME . '" AND TABLE_NAME = "' . $tablename . '"'
        );
    }

    function createCheckerTablesTable()
    {
        dbQuery(
            'CREATE TABLE checker_tables (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                caption VARCHAR(255) NOT NULL,
                goals JSON NOT NULL,
                created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                modified TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
            )'
        );
    }

    function getAllCheckerTables()
    {
        $results = dbQuery(
            'SELECT * FROM checker_tables ORDER BY created DESC'
        );

        if ($results) {
            foreach ($results as $key => $value) {
                $results[$key]['goals'] = json_decode($results[$key]['goals'], true);
            }
        }

        return $results;
    }

    function getCheckerTableById($id)
    {
        $result = dbQuery(
            'SELECT * FROM checker_tables WHERE id = :id LIMIT 1',
            ['id' => $id]
        )[0];

        if ($result) {
            $result['goals'] = json_decode($result['goals'], true);
        }

        return $result;
    }

    function addCheckerTable($checkerTable)
    {
        dbQuery(
            'INSERT INTO checker_tables (caption, goals) VALUES (:caption, :goals)', [
                'caption' => $checkerTable['caption'],
                'goals' => json_encode($checkerTable['goals'])
            ]
        );
    }

    function updateCheckerTable($id, $checkerTable)
    {
        dbQuery(
            'UPDATE checker_tables SET caption = :caption, goals = :goals WHERE id = :id LIMIT 1', [
                'id' => $id,
                'caption' => $checkerTable['caption'],
                'goals' => json_encode($checkerTable['goals'])
            ]
        );
    }

    function deleteCheckerTable($id)
    {
        dbQuery(
            'DELETE FROM checker_tables WHERE id = :id LIMIT 1',
            ['id' => $id]
        );
    }

    function createNewTableBasedOnLastTable($date)
    {
        $tables = getAllCheckerTables();
        foreach ($tables[0]['goals'] as $row) {
            $goals[] = [
                'goal' => $row['goal'],
                'colorIndex' => $row['colorIndex'],
                'days' => ['mon' => false, 'tue' => false, 'wed' => false, 'thu' => false, 'fri' => false, 'sat' => false, 'sun' => false]
            ];
        }
        addCheckerTable([
            'caption' => $date,
            'goals' => $goals
        ]);
    }
