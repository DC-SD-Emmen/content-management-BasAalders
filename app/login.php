<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="style.css">

    </head>
    <body>
        <h1 id="topTextLogin">Login</h1>
        <button id="backToHomePage" onclick="window.location.href = 'index.php'">Back to Homepage</button>
        <button onclick='window.location.href = "register.php"' id="switchButton">Register</button>
        <?php
        if (!empty($_SESSION['error'])) {
            echo '<p id="error">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }else if (!empty($_SESSION['success'])){
            echo '<p id="success">' . $_SESSION['success'] . '</p>';
            unset($_SESSION['success']);
        }
        ?>
        <form action="userHandeling.php" method="post" id="loginForm">
            <label>Login</label>
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <input class="submit" type="submit" value="Login" name="login">
        </form>
    </body>
</html>
