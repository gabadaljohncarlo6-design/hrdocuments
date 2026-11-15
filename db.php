<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "hrdb"
);

if(!$conn){
    die("Database Connection Failed");
}
include __DIR__ . "/includes/session_guard.php";
?>