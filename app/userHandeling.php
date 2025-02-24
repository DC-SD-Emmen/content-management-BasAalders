<?php
include_once 'classes/loginManager.php';
include_once 'classes/gameManager.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = new loginManager();
    if (isset($_POST["register"])) {
        $username = htmlspecialchars($_POST["username"]);
        $password = $_POST["password"];
        $username = ucfirst(trim($username));
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $login->addLogin($username, $hashedPassword);
    }elseif (isset($_POST["login"])) {
        $username = htmlspecialchars($_POST["username"]);
        $password = $_POST["password"];
        $username = ucfirst(trim($username));
        $login->login($username, $password);
    }elseif (isset($_POST["addToWhitelist"])) {
        session_start();
        $gameManager = new gameManager();
        $game_id = $_POST["gameId"];
        $user_id = $_SESSION["userId"];
        $gameManager->add_favorite_games($game_id, $user_id);
    }elseif (isset($_POST["deWhitelist"])) {
        session_start();
        $gameManager = new gameManager();
        $game_id = $_POST["gameId"];
        $user_id = $_SESSION["userId"];
        $gameManager->remove_favorite_games($game_id, $user_id);
    }
}