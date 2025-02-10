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
include_once 'informationDatabase.php';
?>
<div class="gridContainer">
    <div  class="girdItem" id="gridItem1">
        <div id="leftnavbar">
            <a href="http://localhost/" class="homepagelink navbarLink">LIBARY</a>
            <a class="notThispage blockCurser">DETAILSPAGE</a>
            <a href="http://localhost/gameSearching.php" class="notThispage navbarLink">SEARCH ENGINE</a>
            <a href="http://localhost/loginSysteem.php" class="notThispage navbarLink">LOGIN</a>
        </div>
        <h1 id="gameLibaryText">Game Libary</h1>
        
    </div>
    <div class="girdItem" id="gridItem2">
        
        <?php
            //gets the data out of the database and displays it in a list
            $gamesOphalen = new DataBase();
            $gamesOphalen->get_data_list(); 
        ?>
    </div>
    <div class="girdItem" id="gridItem3">
        <?php    
            //gets the data out of the database and displays it in big pictures
            $gamesOphalen->get_data_list_picture();
        ?>
    </div>
</div>
</body>
</html>