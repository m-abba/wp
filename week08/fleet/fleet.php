<?php
//log on to the server with host, username, password
$db = mysqli_connect("localhost", "root", "", "wpDB");

//execute a select all query and assign result to a variable called $results
$results = mysqli_query($db, "select * from fleet");

//loop through the table of results printing each row
while ($row = mysqli_fetch_array($results)) {
    print "<p>";
    print " ";
    print $row['id'];
    print " ";
    print $row['make'];
    print " ";
    print $row['model'];
    print " ";
    print $row['manufactured'];
    print "</p>";
}
