<?php
$title = "Login Process";

include('includes/db_connect.inc');

$sql = "select username, password from users where username = ? and password = SHA(?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$username = $_POST['username'];
$password = $_POST['password'];

$stmt->execute();

$result = $stmt->get_result();
session_start();
if ($result->num_rows > 0) {
    $_SESSION['username'] = $username;
    // print ($_SESSION['username']);
}

$conn->close();
header("Location: index.php"); // redirect to the index page
exit(0);