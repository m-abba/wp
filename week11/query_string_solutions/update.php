<?php
$title = "Update Confirmation";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/db_connect.inc');


// error checking
$error = false;
// check if the form has been submitted
// check if the id is set
if (!empty($_POST['countryid'])) {
    foreach ($_POST as $key => $val) {
        $$key = trim($val);
    }
    $image = $_FILES['image']['name'];
    $temp = $_FILES['image']['tmp_name'];

    $sql = " select * from country where countryid = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        exit("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $countryid);
    $stmt->execute();
    $results = $stmt->get_result();
    if ($results->num_rows > 0) {
        foreach ($results as $row) {
            $countryname = $row['countryname'];
            $old_image = $row['image'];
        }
    }
    if (empty($image)) {
        $image = $old_image;
    }
    $sql = "update country set description = ?, image = ? where countryid = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        exit("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssi", $description, $image, $countryid);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo "<p>Record $countryname updated successfully</p>";
        if ($image != $old_image) {
            // delete the old image 
            if (file_exists('images/' . $old_image)) {
                unlink('images/' . $old_image);
            }
            // upload the new image 
            if (move_uploaded_file($temp, 'images/' . $image)) {
                echo "<p>Image moved to folder</p>";
            } else {
                echo "<p>Image not moved to folder</p>";
            }
        }
    } else {
        $error = true;
    }
} else {
    $error = true;
}
if ($error) {
    echo "<p>Record not updated</p>";
}

include('includes/footer.inc');