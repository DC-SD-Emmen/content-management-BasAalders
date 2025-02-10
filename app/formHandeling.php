<?php
include_once  'informatieDatabase.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new DataBase();
    $db->handlePostRequest($_POST);
}