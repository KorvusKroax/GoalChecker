<?php
    if (isset($_POST['name'])) $name = trim($_POST['name']);
    if (isset($_POST['password'])) $password = $_POST['password'];

    if (isset($_POST['login'])) {
        if (($_SESSION['error'] = validateLogin($name, $password)) == null) {
            $_SESSION['user'] = getUserByName($name);
            unset($_SESSION['login']);
            header('location: index.php');
            exit();
        }
    }
?>



<?php require('header.php'); ?>

<main>
    <div class="container">
        <form method="post">
            <div>
                <span>név:</span><br>
                <input type="text" name="name" value="<?= isset($name) ? $name : "" ?>" required>
            </div>
            <div>
                <span>jelszó:</span><br>
                <input type="password" name="password" value="<?= isset($password) ? $password : "" ?>" required>
            </div>
            <div class="actions">
                <button type="submit" name="login">Belépés</button>
                <a href="signup.php">Regisztráció</a>
            </div>
        </form>
        <?php
            if (isset($_SESSION['error'])) {
                echo '<br><span class="error">' . $_SESSION['error'] . '</span><br>';
                unset($_SESSION['error']);
            }
        ?>
    </div>
</main>

<?php require('footer.php'); ?>
