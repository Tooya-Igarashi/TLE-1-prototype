<?php
$host       = "127.0.0.1";
$user       = "root";
$dbpassword   = "";
$database   = "better_medical";

$db = mysqli_connect($host, $user, $dbpassword, $database)
    or die("Error: " . mysqli_connect_error());;
