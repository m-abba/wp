<?php
$servername = "talsprddb02.int.its.rmit.edu.au";
$username = "e121189";
$password = "rmit1234";
$dbname = "e121189";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
