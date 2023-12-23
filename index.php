<?php
    require('db_init.php');

    if (!isset($_SESSION["user"])) {
        require('login.php');
    } else {
        require('home.php');
    }
