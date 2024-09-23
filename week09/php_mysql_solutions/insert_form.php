<?php
$title = "Insert form";
include('includes/header.inc');
include('includes/nav.inc');
?>

<form action="insert.php" method="post" enctype="multipart/form-data">
    <h2> Insert a new country</h2>

    <label>Country Name: </label>
    <input type="text" name="countryname"><br><br>
    <label>Description: </label>
    <textarea name="description"> </textarea><br><br>
    <label>Select an image: </label>
    <input type="file" name="image"><br><br>
    <label>Image caption: </label>
    <input type="text" name="caption"><br><br>

    <input type="submit" name="submit" value="insert"><br><br>
</form>
<?php
include('includes/footer.inc');