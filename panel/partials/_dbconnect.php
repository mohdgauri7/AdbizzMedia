<?php
$server = "127.0.0.1";
$username = "adbizzmedia";
$password = "Password@2930";
$database = "u504804622_panelDB";

$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn){
    die("Error". mysqli_connect_error());
}

?>
