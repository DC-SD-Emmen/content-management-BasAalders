<?php session_start();

if (empty($_SESSION['username'])) {
    header('location: index.php');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body id="settingsPage">
<?php
if (!empty($_SESSION['error'])) {
    echo '<p id="error">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
} else if (!empty($_SESSION['success'])) {
    echo '<p id="success">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}
?>
<button id="backToHomePage" onclick="window.location.href = 'index.php'">Back to Homepage</button>
<form action="userHandeling.php" method="post">
    <h1>change password</h1>
    <input type="password" name="password" placeholder="current password" required>
    <input type="password" name="newPassword"  placeholder="new password" required>
    <input type="submit" name="passwordChange" value="submit">
</form>
    <form action="userHandeling.php" method="post">
        <h1>change username</h1>
        <input type="text" name="newUsername" placeholder="new username" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="submit" name="usernameChange" value="submit">
    </form>
    <form action="userHandeling.php" method="post">
        <h1>delete account</h1>
        <input type="password" name="password" placeholder="password" required>
        <input type="submit" name="deleteAccount" value="delete account">
    </form>
</body>
</html>