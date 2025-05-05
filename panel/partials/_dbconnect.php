<?php
// $server = "localhost";
// $username = "root";
// $password = "-QER4skRz_NbYbu";
// $database = "panelDB";

$server = "localhost";
$username = "root";
$password = "";
$database = "panelDB";

$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn){
//     echo "success";
// }
// else{
    die("Error". mysqli_connect_error());
}

?>
