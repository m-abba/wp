<?php
$title = "Register Process";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/db_connect.inc');

$sql = "insert into users (username, password, reg_date) values (?, SHA(?), now())";

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();

session_start();
if ($stmt->affected_rows > 0) {
    $_SESSION['usrmsg'] = "You have successfully registered";
} else {
    $_SESSION['usrmsg'] = "There was an error with your registration";
}

$conn->close();
header("Location: index.php");
exit(0);
