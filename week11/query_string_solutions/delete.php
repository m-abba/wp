<?php
$title = "Delete Record";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/db_connect.inc');

$error = false;
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "select * from country where countryid = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        exit("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $results = $stmt->get_result();
    if ($results->num_rows > 0) {
        foreach ($results as $row) {
            $old_image = $row['image'];
        }
    }
    $sql = "delete from country where countryid = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo "<p>Record deleted successfully</p>";
        if (file_exists('images/' . $old_image)) {
            unlink('images/' . $old_image);
        }
    } else {
        $error = true;
    }
} else {
    $error = true;
}
if ($error) {
    echo "<p>Record not deleted</p>";
}
include('includes/footer.inc');