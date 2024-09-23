<?php
// database details
$server = "localhost";
$user = "root";
$pass = "";
$dbname = "Agent";

// start the connection
$conn = new mysqli($server, $user, $pass, $dbname);

// check the connection
if ($conn->connect_error) {
    exit("Connection Failed: " . $conn->connect_error);
}
