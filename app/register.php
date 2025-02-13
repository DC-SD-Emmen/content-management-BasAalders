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
<h1 id="topTextLogin">Register</h1>
<button id="backToHomePage" onclick="window.location.href = 'index.php'">Back to Homepage</button>
<button onclick='window.location.href = "login.php"' id="switchButton">Login</button>
<?php
if (!empty($_SESSION['error'])) {
    echo '<p id="error">' . $_SESSION['error'] . '</p>';
    session_unset();
}else if (!empty($_SESSION['success'])){
    echo '<p id="success">' . $_SESSION['success'] . '</p>';
    session_unset();
}
?>
<form action="loginHandeling.php" method="post" id="registerForm">
    <label>Register</label>
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <input class="submit" type="submit" value="register" name="register">
</form>

</body>
</html>
