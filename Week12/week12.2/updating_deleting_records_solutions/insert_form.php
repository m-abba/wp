<?php
$title = "Insert form";
include('includes/header.inc');
include('includes/nav.inc');
?>
<form method="post" action="insert.php" enctype="multipart/form-data">

    <h3>Insert a new country:</h3>

    <label>Country Name:</label>
    <input type="text" name="countryname" />
    <label>Description</label>
    <textarea cols="50" rows="5" name="description"></textarea>
    <label>Select an Image:</label>
    <input type="file" name="image" />
    <label>Image Caption:</label>
    <input type="text" name="caption" />
    <input type="submit" name="submit" value="Insert" />
</form>
<?php
include('includes/footer.inc');
?>