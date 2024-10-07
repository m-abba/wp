<?php
$title = "Home";
include('inlcudes/header.inc');
include('inlcudes/nav.inc');
?>
<table>
    <tr>
        <th>Address</th>
        <th>Room</th>
        <th>Rent</th>
    </tr>
    <?php
    include('inlcudes/db_connect.inc');

    $sql = "Select * from Property";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        while ($row = mysqli_fetch_array($result)) {
            print "<tr>\n";
            print "<td><a href='details.php?id={$row['id']}'>{$row['address']} </a></td>\n";
            print "<td>{$row['rooms']}</td>\n";
            print "<td>{$row['rent']}</td\n>";
            print "</tr>\n";

        }
    } else {
        echo " <tr><td> 0 Results</td></tr>";
    }

    ?>

</table>

<?php
include('inlcudes/footer.inc');
?>