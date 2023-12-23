<?php

    if (isset($_POST["name"])) $_SESSION["login"]["name"] = trim($_POST["name"]);
    if (isset($_POST["password"])) $_SESSION["login"]["password"] = $_POST["password"];
    if (isset($_POST["login"])) {
        $_SESSION["login"]["error"] = validateLogin(
            $_SESSION["login"]["name"],
            $_SESSION["login"]["password"]
        );

        if (empty($_SESSION["login"]["error"])) {
            $_SESSION["user"] = getUserByName($_SESSION["login"]["name"]);
            unset($_SESSION["login"]);
        }
    }

    header("location: index.php");
    exit();
