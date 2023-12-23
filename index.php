<?php
    session_start();
    // $_SESSION['user']['name'] = 'valaki';
    // $_SESSION['user']['table'] = strtolower($_SESSION['user']['name']);

    require('db_init.php');
?>



<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Korvus">

        <link rel="icon" href="img/favicon.png">

        <link rel="stylesheet" href="css/main.css">
        <!-- <link rel="stylesheet" href="css/footer_to_bottom.css"> -->
        <link rel="stylesheet" href="css/table.css">
        <link rel="stylesheet" href="css/checkbox.css">
        <link rel="stylesheet" href="css/button.css">

        <script src="js/updateTable.js" defer></script>
        <script src="js/editTable.js" defer></script>

        <title>GoalChecker</title>
    </head>
    <body>
        <?php if (!isset($_SESSION["user"])) : ?>
            <main>
                <div class="container">
                    <form method="post" action="login.php">
                        <div>
                            <span>név:</span><br>
                            <input type="text" name="name" value="<?= isset($_SESSION["login"]["name"]) ? $_SESSION["login"]["name"] : "" ?>" required>
                        </div>
                        <div>
                            <span>jelszó:</span><br>
                            <input type="password" name="password" value="<?= isset($_SESSION["login"]["password"]) ? $_SESSION["login"]["password"] : "" ?>" required>
                        </div>
                        <div class="actions">
                            <button type="submit" name="login">belépés</button>
                            <a href="signup.php">regisztráció</a>
                        </div>
                    </form>
                    <?php
                        if (isset($_SESSION["login"]["error"])) {
                            echo "<span class='error'>" . $_SESSION["login"]["error"] . "</span><br>";
                            unset($_SESSION["login"]["error"]);
                        }
                    ?>
                </div>
            </main>
        <?php else : ?>
            <?php require('home.php'); ?>
        <?php endif; ?>
    </body>
</html>
