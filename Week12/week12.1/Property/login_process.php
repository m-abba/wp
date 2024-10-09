<?php
session_start();

include("includes/db_connect.inc");
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "select * from users where username = ? and password = SHA(?)";

$stmt = $conn->prepare($sql);


$stmt->bind_param("ss", $username, $password);

$stmt->execute();

$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $_SESSION['username'] = $username;

    echo "$username";
    echo "$password";
}
$conn->close();
// header("Location:index.php");
// exit(0);
