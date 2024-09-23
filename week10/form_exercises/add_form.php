<?php
$title = "Add New Property";
include('inlcudes/header.inc');
include('inlcudes/nav.inc');

?>
<h2> Add new Property </h2>
<form action="add.php" method="post">
    <label for="address">Address</label>
    <input type="text" name="address" id="address"><br>
    <label for="rooms">Rooms</label>
    <input type="text" name="rooms" id="rooms"><br>
    <label for="rent">Rent</label>
    <input type="text" name="rent" id="rent"><br>

    <input type="submit" value="Add new Property">

</form>

<?php
include('inlcudes/footer.inc');
?>