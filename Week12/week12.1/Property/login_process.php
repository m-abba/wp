<?php
$title = "Login Process";

include('includes/db_connect.inc');
$username = $_POST['username'];
$password = $_POST['password'];
$sql = "select username, password from users where username = ? and password = SHA(?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);

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