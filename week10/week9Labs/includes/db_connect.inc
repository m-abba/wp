<?php
//db_connect.inc
//Check what server you are accessing
if (strstr($_SERVER['SERVER_NAME'], 'localhost')) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "destination";
} else {
    $servername = "talsprddb02.int.its.rmit.edu.au";
    $username = "s12345";
    $password = "your Jacob5 password";
    $dbname = "s12345";
}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
