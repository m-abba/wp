<?php
$title = "Property details";
include('inlcudes/header.inc');
include('inlcudes/nav.inc');
include('inlcudes/db_connect.inc');

if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "Select * from Property where id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    print "<h2>Details</h2>";
    print "<p>Address: {$row['address']}</p>";
    print "<p>Rooms: {$row['rooms']}</p>";
    print "<p>Rent: {$row['rent']}</p>";
} else {
    echo "No id provided";
}

include('inlcudes/footer.inc');
?>