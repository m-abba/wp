<?php
$title = 'Fleet 3';
include("header.inc");
include("db_connect.inc");
//execute a select all query and assign result to a variable called $results
$sql = "select * from fleet";
$result = $conn->query($sql);

//loop through the table of results printing each row
while ($row = $result->fetch_array()) {
    print "<div>";
    print "<h2>" . $row['id'] . "</h2>";
    print "<h2>{$row['make']} {$row['model']}</h2>";
    print "<h3>{$row['manufactured']}</h3>";
    print "</div>";
}
include("footer.inc");
