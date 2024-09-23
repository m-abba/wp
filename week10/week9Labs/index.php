<?php
$title = "Home";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/db_connect.inc');

$sql = "select countryid, countryname, image, caption from country";
$records = $conn->query($sql);

foreach ($records as $row) {
    echo "<section class='display'>";
    echo "<h2> {$row['countryname']} </h2>";
    echo "<img src='images/{$row['image']}' alt='{$row['caption']}' class='img_size'>";
    echo "<p><a href='details.php?id={$row['countryid']}'>Read More</a></p>";
    echo "</section>";
}

include('includes/footer.inc');
