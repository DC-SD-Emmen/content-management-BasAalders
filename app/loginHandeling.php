<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="style.css">
    </head>
</html>

<?php
include_once 'informationDatabase.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new DataBase();
    if (isset($_POST["register"])) {
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);
        echo "login in... <br> please wait";
        echo "<br> Loggin is as: $username";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        echo "<br> hashed pasword is: $hashedPassword";
        $db -> addLogin($username, $hashedPassword);
    }else if (isset($_POST["login"])) {
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);
        echo "login in... <br> please wait";
        echo "<br> Loggin is as: $username";
        $db -> login($username, $password);
    }
}