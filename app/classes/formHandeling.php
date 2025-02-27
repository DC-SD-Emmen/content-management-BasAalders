<?php
include_once 'gameManager.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $db = new gameManager();
        $db->handlePostRequest();
}