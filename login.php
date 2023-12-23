<?php
    if (isset($_POST['name'])) $name = trim($_POST['name']);
    if (isset($_POST['password'])) $password = $_POST['password'];

    if (isset($_POST['login'])) {
        if (($_SESSION['error'] = validateLogin($name, $password)) == null) {
            $_SESSION['user'] = getUserByName($name);
            header('location: index.php');
            exit();
        }
    }
?>



<?php $headerText = 'Jelentkezz be!'; require('header.php'); ?>

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
            <div class="actions">
                <button type="submit" name="login">Belépés</button>
                <a href="signup.php">Regisztráció</a>
            </div>
        </form>
    </div>
</main>

<?php require('footer.php'); ?>
