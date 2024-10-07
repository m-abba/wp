<?php
require_once('includes/db_connect.inc');
$title = "Modify";
include('includes/header.inc');
include('includes/nav.inc');

$sql = "select countryid, countryname, image from country";
$results = $conn->query($sql);
?>

<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Image</th>
        <th colspan="2">Make Changes</th>
    </tr>

    <?php
    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>{$row['countryid']}</td>";
        echo "<td>{$row['countryname']}</td>";
        echo "<td><img class='thumb' src='images/{$row['image']}' alt='{$row['countryname']}'></td>";
        echo "<td><a class='link' href='update_form.php?id={$row['countryid']}'>Update</a></td>";
        echo "<td><a class='link' href='delete_confirm.php?id={$row['countryid']}'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    include('includes/footer.inc');
    ?>