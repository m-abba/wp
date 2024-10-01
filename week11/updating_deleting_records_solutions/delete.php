<?php
$title = "Delete Record";
include('includes/header.inc');
include('includes/nav.inc');
require_once('includes/db_connect.inc');

$error = false;
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "select * from country where countryid=?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $records = $stmt->get_result();
    if ($records->num_rows > 0) {
        foreach ($records as $row) {
            $oldimage = $row['image'];
        }
    }
    $sql = "delete from country where countryid = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo "<p>Record deleted</p>";
        if (file_exists('images/' . $oldimage)) {
            unlink('images/' . $oldimage);
        }
    } else {
        $error = true;
    }
} else {
    $error = true;
}
if ($error) {
    echo "<p>Record NOT deleted<p>";
}
include('includes/footer.inc');
