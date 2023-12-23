<?php
    require('db_init.php');

    if (isset($_POST['name'])) $name = trim($_POST['name']);
    if (isset($_POST['password'])) $password = $_POST['password'];
    if (isset($_POST['rePassword'])) $rePassword = $_POST['rePassword'];

    if (isset($_POST['signup'])) {
        if (($_SESSION['error'] = validateName($name)) == null) {
            if (($_SESSION['error'] = validatePassword($password, $rePassword)) == null) {
                addUser($name, $password);
                $_SESSION['user'] = getUserByName($name);
                header('location: index.php');
                exit();
            }
        }
    }

    if (isset($_POST['back'])) {
        header('location: index.php');
        exit();
    }
?>



<?php $headerText = 'Regisztráció...'; require('header.php'); ?>

<main>
    <div class="container">
        <form method="post">
            <div>
                <span>név:</span><br>
                <input type="text" name="name" value="<?= isset($name) ? $name : "" ?>">
            </div>
            <div>
                <span>jelszó:</span><br>
                <input type="password" name="password" value="<?= isset($password) ? $password : "" ?>">
            </div>
            <div>
                <span>jelszó mégegyszer:</span><br>
                <input type="password" name="rePassword" value="<?= isset($rePassword) ? $rePassword : "" ?>">
            </div>
            <div class="actions">
                <button type="submit" name="signup">OK</button>
                <button type="submit" name="back">Vissza</button>
            </div>
        </form>
    </div>
</main>

<?php require('footer.php'); ?>
