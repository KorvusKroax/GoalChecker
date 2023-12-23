<?php

    function isDatabaseExists()
    {
        $con = new PDO(DB_DRIVER . ':host=' . DB_HOST, DB_USER, DB_PASSWORD);
        $result = $con->query('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "' . DB_NAME . '"');
        return (bool) $result->fetchColumn();
    }

    function createDatabase()
    {
        $con = new PDO(DB_DRIVER . ':host=' . DB_HOST, DB_USER, DB_PASSWORD);
        $con->exec('CREATE DATABASE ' . DB_NAME);
    }

    function dbQuery($query, $data = array())
    {
        $con = new PDO(DB_DRIVER . ':host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
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



    function createUsersTable()
    {
        dbQuery(
            'CREATE TABLE users (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                modified TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
            )'
        );
    }

    function getAllUsers()
    {
        return dbQuery("SELECT * FROM users");
    }

    function getUserByName($name)
    {
        $result = dbQuery('SELECT * FROM users WHERE name = :name LIMIT 1', ['name' => $name]);
        return $result[0] ?? false;
    }

    function addUser($name, $password)
    {
        dbQuery(
            'INSERT INTO users (name, password) VALUES (:name, :password)', [
                'name' => $name,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]
        );
    }

    function validateName($name)
    {
        if (empty($name)) {
            return 'nincs név megadva';
        }

        if (strlen($name) < MIN_NAME_LENGTH) {
            return 'túl rövid név (min: ' . MIN_NAME_LENGTH . ' karakter)';
        }

        if (!preg_match('/^[\w\s.]+$/ui', $name)) {
            return 'érvénytelen név (csak betűk, számok, szóköz, aláhúzás és pont használható)';
        }

        if (!empty($user = getUserByName($name))) {
            return 'ezen a néven már létezik felhasználó';
        }
    }

    function validatePassword($password, $retype_password)
    {
        if (empty($password)) {
            return 'nincs jelszó megadva';
        }

        if (strlen($password) < MIN_PASSWORD_LENGTH) {
            return 'túl rövid jelszó (min: ' . MIN_PASSWORD_LENGTH . ' karakter)';
        }

        if ($password !== $retype_password) {
            return 'a két jelszó nem egyezik';
        }
    }

    function validateLogin($name, $password)
    {
        if (empty($name) || empty($password)) {
            return 'érvénytelen név/jelszó'; // log: nincs név/jelszó megadva
        }

        if (empty($user = getUserByName($name))) {
            return 'érvénytelen név/jelszó'; // log: nem létezik ilyen néven felhasználó
        }

        if (!password_verify($password, $user['password'])) {
            return 'érvénytelen név/jelszó'; // log: nem megfelelő jelszó
        }
    }



    function createCheckerTablesTable()
    {
        dbQuery(
            'CREATE TABLE ' . $_SESSION['user']['table'] . ' (
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
            'SELECT * FROM ' . $_SESSION['user']['table'] . ' ORDER BY created DESC'
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
            'SELECT * FROM ' . $_SESSION['user']['table'] . ' WHERE id = :id LIMIT 1',
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
            'INSERT INTO ' . $_SESSION['user']['table'] . ' (caption, goals) VALUES (:caption, :goals)', [
                'caption' => $checkerTable['caption'],
                'goals' => json_encode($checkerTable['goals'])
            ]
        );
    }

    function updateCheckerTable($id, $checkerTable)
    {
        dbQuery(
            'UPDATE ' . $_SESSION['user']['table'] . ' SET caption = :caption, goals = :goals WHERE id = :id LIMIT 1', [
                'id' => $id,
                'caption' => $checkerTable['caption'],
                'goals' => json_encode($checkerTable['goals'])
            ]
        );
    }

    function deleteCheckerTable($id)
    {
        dbQuery(
            'DELETE FROM ' . $_SESSION['user']['table'] . ' WHERE id = :id LIMIT 1',
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
