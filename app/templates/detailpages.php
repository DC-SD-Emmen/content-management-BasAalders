<div class="girdItem" id="gridItem3">
<?php
if (!empty($_SESSION['error'])) {
    echo '<p id="error">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}
// replaces the big pictures with all the data
$gameDetails = $gamesOphalen->get_game_details($id);
$usernames = $gamesOphalen->get_users_by_game_id($id);
$screenshotsArray = explode(',', $gameDetails['screenshots']);
if ($gameDetails) {
    echo "<h1>{$gameDetails['title']}</h1>";
    echo "<img src='{$gameDetails['afbeelding']}' id='coverImg' alt='{$gameDetails['title']}'>";
    echo "<p><strong>Genre:</strong> {$gameDetails['genre']}</p>";
    echo "<p><strong>Platform:</strong> {$gameDetails['platform']}</p>";
    echo "<p><strong>Release Year:</strong> {$gameDetails['release_year']}</p>";
    echo "<p><strong>Rating:</strong> {$gameDetails['rating']}</p>";
    echo "<p><strong>People that have whislisted this: </strong>{$usernames}</p>";
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