<?php
include_once 'classes/loginManager.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = new loginManager();
    if (isset($_POST["register"])) {
        $username = htmlspecialchars($_POST["username"]);
        $password = $_POST["password"];
        $username = ucfirst(trim($username));
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $login->addLogin($username, $hashedPassword);
    }else if (isset($_POST["login"])) {
        $username = htmlspecialchars($_POST["username"]);
        $password = $_POST["password"];
        $username = ucfirst(trim($username));
        $login->login($username, $password);
    }
}