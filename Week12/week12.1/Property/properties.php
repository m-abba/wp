<?php
$title = "Library";
include('includes/header.inc');
?>
<h1>Welcome to the Agent database</h1>
<?php
include('includes/nav.inc');
?>
<table>
    <tr>
        <th>Address</th>
        <th>Rooms</th>
        <th>Rent</th>
    </tr>
    <?php
    //connect
    include('includes/db_connect.inc');

    $sql = "select * from Property";

    $result = $conn->query($sql);
    //loop through the table of results printing each row
    if ($result->num_rows > 0) {

        while ($row = mysqli_fetch_array($result)) {
            print "<tr>\n";
            print "<td><a href='property.php?id={$row['id']}'>{$row['address']}</a></td>\n";
            print "<td>{$row['rooms']}</td>\n";
            print "<td>{$row['rent']}</td>\n";
            print "</tr>\n";
        }
    } else {
        echo "<tr><td colspan=4>0 results</td></tr>";
    }
    ?>
</table>
<?php
$conn->close();
include('includes/footer.inc');
?>