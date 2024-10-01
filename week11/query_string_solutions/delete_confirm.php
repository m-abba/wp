<?php
$title = "Delete Confirmation";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/db_connect.inc');


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
            echo "<h3>Are you sure you want to delete " . $row['countryname'] . "?</h3>";
            echo "<p> {$row['description']} </p>";
            echo "<img src='images/{$row['image']}' alt='{$row['caption']}' />";
            $imagename = urldecode('images/' . $row['image']);
            echo "<a href='delete.php?id={$row['countryid']}'>Yes</a>";
            echo "<a href='modify_table.php'>No</a>";
        }
    }
}
include('includes/footer.inc');