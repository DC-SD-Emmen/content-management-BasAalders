<?php
include_once 'informationDatabase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $db = new DataBase();
        $db->handlePostRequest($_POST);
}