<?php

$host = "mysql"; // Le host est le nom du service, présent dans le docker-compose.yml
$dbname = "my-wonderful-website";
$charset = "utf8";
$port = "3306";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Jersey+15&family=Noto+Sans+JP:wght@100..900&family=Phetsarath:wght@400;700&display=swap" rel="stylesheet">
    <title>Bas' game search engine</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 id="headlineText">Bas' game search engine</h1>
    <button id="goToGamelibary">gamelibary</button>
    <form id="formZoeken">
        <p id="searchText">Zoek op:</p>
        <select name="searchType" id="searchType">
            <option value="gameName">name</option>
            <option value="gameGenre">genre</option>
            <option value="platform">platform</option>
            <option value="store">store</option>
        </select>
        <p id="searchText">hoeveel games op 1 pagina:</p>
        <select name="pageSize" id="pageSize">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="12">12</option>
            <option value="15">15</option>
            <option value="20">20</option>
            <option value="24" selected>24</option>
        </select>
        <input type="text" id="search" placeholder="Zoek een game">
        <button id="searchGames">Zoek</button>
    </form>
    <pre id="games-list"></pre>
    <div id="pageButtons">
        <button id="previous" class="page-button">Previous</button>
        <button id="next" class="page-button">Next</button>
    </div>


    <script src="script.js"></script>
</body>
</html>
