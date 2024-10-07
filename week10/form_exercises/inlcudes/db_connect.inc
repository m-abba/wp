<?php
// database details
if (strstr($_SERVER['SERVER_NAME'], 'localhost')) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "destination";
} else {
    $servername = "talsprddb02.int.its.rmit.edu.au";
    $username = "e121189";
    $password = "your jacob5 password";
    $dbname = "e121189";
}

// start the connection
$conn = new mysqli($server, $user, $pass, $dbname);

// check the connection
if ($conn->connect_error) {
    exit("Connection Failed: " . $conn->connect_error);
}
