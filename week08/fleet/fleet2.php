<?php
$title = "Cars";
include("header.inc");
//log on to the server with host, username, password and db
$db = mysqli_connect("localhost", "root", "", "wp");

//execute a select all query and assign result to a variable called $results
$results = mysqli_query($db, "select * from fleet");

//loop through the table of results printing each row
while ($row = mysqli_fetch_array($results)) {
    print "<div>";
    print "<h2>{$row['id']} - {$row['make']} {$row['model']}</h2>";
    print "<h3>{$row['manufactured']}</h3>";
    print "</div>";
}
include("footer.inc");
