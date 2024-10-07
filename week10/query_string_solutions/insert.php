<?php
$title = "Insert";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/config.inc');
include('includes/db_connect.inc');


foreach ($_POST as $key => $val) {
    $$key = trim($val);
}
$image = $_FILES['image']['name'];
$temp = $_FILES['image']['tmp_name'];
$error = $_FILES['image']['error'];

$sql = "INSERT INTO country(countryname,description,image,caption) VALUES (?,?,?,?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    exit("An error occurred");
}

$stmt->bind_param("ssss", $countryname, $description, $image, $caption);
$stmt->execute();
if ($stmt->affected_rows > 0) {
    echo '<p>New record successfully inserted into the database</p>';
    if (move_uploaded_file($temp, 'images/' . $image)) {
        echo "<p>Image moved to folder</p>";
    } else {
        echo "<p>Image not moved to folder</p>";
    }
} else {
    echo '<p>Record not inserted into the database</p>';
}
include('includes/footer.inc');
