<?php
include_once 'classes/loginManager.php';
include_once 'classes/gameManager.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = new loginManager();
    $gameManager = new gameManager();
    if (isset($_POST["register"])) {
        $username = htmlspecialchars($_POST["username"]);
        $password = $_POST["password"];
        $email = htmlspecialchars($_POST["email"]);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $username = ucfirst(trim($username));
        $login->addLogin($username, $email ,$hashedPassword);
    }elseif (isset($_POST["login"])) {
        $username = htmlspecialchars($_POST["username"]);
        $password = $_POST["password"];
        $username = ucfirst(trim($username));
        $login->login($username, $password);
    }elseif (isset($_POST["addToWishlist"])) {
        session_start();
        $game_id = $_POST["gameId"];
        $user_id = $_SESSION["userId"];
        $gameManager->add_favorite_games($game_id, $user_id);
    }elseif (isset($_POST["deWishlist"])) {
        session_start();
        $game_id = $_POST["gameId"];
        $user_id = $_SESSION["userId"];
        $gameManager->remove_favorite_games($game_id, $user_id);
    }elseif (isset($_POST["deleteAccount"])) {
        $password = $_POST["password"];
        $login->eraseCredentials($password);
    }elseif (isset($_POST["usernameChange"])) {
        $newUsername = htmlspecialchars($_POST["newUsername"]);
        $newUsername = ucfirst(trim($newUsername));
        $password = $_POST["password"];
        $login->changeUsername($password, $newUsername);
    }elseif (isset($_POST["passwordChange"])) {
        $newPassword = $_POST["newPassword"];
        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $currentPassword = $_POST["password"];
        $login->changePassword($currentPassword, $newPassword);
    }
}