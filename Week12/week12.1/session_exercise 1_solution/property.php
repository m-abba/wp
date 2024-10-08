<?php
$title = "Property details";
include('includes/header.inc');
?>
<h1>Welcome to the Agent database</h1>
<?php
include('includes/nav.inc');
?>

<?php
if (!empty($_GET['id'])) {
    include('includes/db_connect.inc');

    $sql = "select * from Property where id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $id);

    $id = $_GET['id'];

    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows == 1) {

        $row = mysqli_fetch_array($result);
        print "<h2>{$row['address']}</h2>";
        print "<h3>by {$row['rooms']}</h3>";
        print "<h4>Rent: {$row['rent']}</h4>";
    }
}
?>
<?php
$conn->close();
include('includes/footer.inc');
?>