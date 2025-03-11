<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stylesheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body class="index">
<?php
include_once 'classes/gameManager.php';
?>
<div class="gridContainer">
    <div  class="girdItem" id="gridItem1">
        <div id="leftnavbar">
            <?php
            if(!empty($_SESSION['username'])){
                echo '<a href="http://localhost/profilepage" class="notThispage navbarLink" id="welcomeText">'.$_SESSION['username'] . "' wishlist"        .'</a>';
            }
            ?>
            <a href="http://localhost/" class="notThispage navbarLink">LIBRARY</a>
            <a href="http://localhost/gameSearching.php" class="notThispage navbarLink">SEARCH ENGINE</a>
            <?
            if (empty($_SESSION['username'])){
                echo '<a href="http://localhost/login.php" class="notThispage navbarLink">LOGIN</a>';
                echo '<a href="http://localhost/register.php" class="notThispage navbarLink">REGISTER</a>';
            }
            if (!empty($_SESSION['username'])){
                echo '<a href="http://localhost/logout.php" class="notThispage navbarLink" id="logout">LOGOUT</a>';
                echo '<a href="http://localhost/usersettings" class="notThispage navbarLink">SETTINGS</a>';
            } ?>
        </div>
        <h1 id="gameLibaryText">Game Libary</h1>


    </div>