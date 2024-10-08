<?php
$title = "Add New Property";
include('includes/header.inc');
?>
<h1>Welcome to the Agent database</h1>
<?php
include('includes/nav.inc');
?>
<h2>Add New Property</h2>
<?php if (isset($_SESSION['username'])) { ?>
    <form action="process_new_property.php" method="post">
        <label for="address">Address</label>
        <input type="text" name="address" id="address" required><br>
        <label for="rooms">Rooms</label>
        <input type="text" name="rooms" id="rooms" required><br>
        <label for="rent">Rent</label>
        <input type="text" name="rent" id="rent" required><br>
        <input type=submit value="Add New Property">
    </form>
<?php } ?>
<?php
include('includes/footer.inc');
?>