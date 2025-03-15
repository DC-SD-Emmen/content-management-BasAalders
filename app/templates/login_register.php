<?php

session_start();

if (!empty($_SESSION['error'])) {
    echo '<p id="error">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
} else if (!empty($_SESSION['success'])) {
    echo '<p id="success">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}

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
    <button id="backToHomePage" onclick="window.location.href = 'index.php'">Back to Homepage</button>
