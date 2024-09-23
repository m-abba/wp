<?php
$title = "Add";
include('inlcudes/header.inc');
include('inlcudes/nav.inc');
include('inlcudes/db_connect.inc');

function validateInput($str)
{
    $val = trim($str);
    return $val;
}

$address = validateInput($_POST['address']);
$room = validateInput($_POST['rooms']);
$rent = validateInput($_POST['rent']);

$sql = "insert into Property (address, rooms, rent) values (?,?,?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param("sid", $address, $room, $rent);

$stmt->execute();

if ($stmt->affected_rows > 0) {
    // header("Location: index.php");
    exit(0);
} else {
    echo "Insert Error";
}

include('inlcudes/footer.inc');
?>