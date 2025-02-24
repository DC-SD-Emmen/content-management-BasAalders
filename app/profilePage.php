<?php
session_start();
if (empty($_SESSION['username'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stylesheet.css">
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
                echo '<a href="http://localhost/profilepage.php" class="homepagelink navbarLink" id="welcomeText">Welcome, '.$_SESSION['username']        .'</a>';
            }
            ?>
            <a href="http://localhost/" class="notThispage navbarLink">LIBARY</a>
            <a class="notThispage blockCurser">DETAILSPAGE</a>
            <a href="http://localhost/gameSearching.php" class="notThispage navbarLink">SEARCH ENGINE</a>
            <?
            if (empty($_SESSION['username'])){
                echo '<a href="http://localhost/login.php" class="notThispage navbarLink">LOGIN</a>';
                echo '<a href="http://localhost/register.php" class="notThispage navbarLink">REGISTER</a>';
            }
            if (!empty($_SESSION['username'])){
                echo '<a href="http://localhost/logout.php" class="notThispage navbarLink" id="logout">LOGOUT</a>';
            } ?>
        </div>
        <?php
        echo '<h1 id="gameLibaryText">Wishlist of '.$_SESSION['username'].'</h1>'
        ?>
    </div>

    <div class="girdItem" id="gridItem2">

        <?php
        //gets the data out of the database and displays it in a list
        $gamesOphalen = new gameManager();
        $gamesOphalen->get_favorite_games_list($_SESSION['userId']);
        ?>
    </div>
    <div class="girdItem" id="gridItem3">
        <?php
        //gets the data out of the database and displays it in big pictures
        $gamesOphalen->get_favorite_games_list_picture($_SESSION['userId']);
        ?>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>