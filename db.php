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

?>