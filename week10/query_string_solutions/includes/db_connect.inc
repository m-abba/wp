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
    //change to your own student number
    $username = "s123456";
    //change to your own Jacob 5 password
    //NOT your RMIT password
    $password = "JACOB5-password";
    //change to your own student number
    $dbname = "s123456";
}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
