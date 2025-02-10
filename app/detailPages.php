<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>details</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="details-page">
<?php
include_once 'informatieDatabase.php'; 
$id = isset($_GET['id']) ? $_GET['id'] : 0;
?>
<div class="gridContainer">
    <div class="girdItem" id="gridItem1">
        <div id="leftnavbar">
            <a href="http://localhost/" class="notThispage">LIBARY</a>
            <a href="" class="homepagelink">DETAILSPAGE</a>
            <a href="http://localhost/gameSearching.php" class="notThispage">SEARCH ENGINE</a>
        </div>
        <h1 id="gameLibaryText">Game Libary</h1>
    </div>
    <div class="girdItem" id="gridItem2">
        <?php
        // gets the data out of the database and displays it in a list
        $gamesOphalen = new DataBase();
        $gamesOphalen->get_data_list();
        ?>
    </div>
    <div class="girdItem" id="gridItem3">
        <?php
        // replaces the big pictures with all the data
        $gameDetails = $gamesOphalen->get_game_details($id);
        $screenshotsArray = explode(',', $gameDetails['screenshots']);
        if ($gameDetails) {
            echo "<h1>{$gameDetails['title']}</h1>";
            echo "<img src='{$gameDetails['afbeelding']}' id='coverImg' alt='{$gameDetails['title']}'>";
            echo "<p><strong>Genre:</strong> {$gameDetails['genre']}</p>";
            echo "<p><strong>Platform:</strong> {$gameDetails['platform']}</p>";
            echo "<p><strong>Release Year:</strong> {$gameDetails['release_year']}</p>";
            echo "<p><strong>Rating:</strong> {$gameDetails['rating']}</p>";
            echo "<p><strong>Screenshots:</strong></p>";
            if (in_array('N/A', $screenshotsArray)) {
                echo "<p>No screenshots available</p>";
            } else {
                echo "<div id='screenshotContainer'>";
                $index = 0;
                foreach ($screenshotsArray as $screenshot) {
                    echo "<img class='screenshot' id='afbeelding{$index}' tabindex='0' src='{$screenshot}' alt='{$gameDetails['title']}'>";
                    $index++;
                }
                echo "</div>";
            }
        } else {
            echo "<h2>Game not found.</h2>";
        }
        ?>
        <a href="#deletebuttonDiv"><div id="deletebutton">delete</div></a>
        <div id="deletebuttonDiv">
            <p class="middleText">are you sure?</p> <br>
            <form id="deletebuttonForm" method="POST">
                <a href="#deletebutton" id="dontdelete"><div>no</div></a>
                <input type="submit" id="yesDeletebutton" name="deleteButon" value="yes">
            </form>
        </div>
        <br>
        <?php
        //calls the delete proses from gameManagement.php
        include_once 'gameManagement.php';
        $gameMngr = new GameManager($gamesOphalen);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['deleteButon'])) {
                $gameMngr-> delete_data($id);
            }
        }   
        ?>
        <div id="lightbox-modal" style="display: none;">
            <span id="lightbox-close" style="cursor: pointer; font-size: 2rem; position: absolute; top: 10px; right: 20px;">&times;</span>
            <img id="lightbox-img" src="" alt="Game Screenshot" style="width: 100%; height: auto;">
        </div>
        <script src="bigImage.js"></script>
    </div>
</div>
</body>
</html>
