<?php
session_start();

if (isset($_SESSION['username'])) {
    function validateInput($str)
    {
        $ret = trim($str);
        return $ret;
    }
    $address = validateInput($_POST['address']);
    $rooms = validateInput($_POST['rooms']);
    $rent = validateInput($_POST['rent']);

    include('includes/db_connect.inc');

    $sql = "INSERT INTO Property (address, rooms, rent) VALUES (?,?,?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssi", $address, $rooms, $rent);

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        //back to home
        header("Location:index.php");
        exit(0);
    } else {
        echo "An error has occured!";
    }
}
