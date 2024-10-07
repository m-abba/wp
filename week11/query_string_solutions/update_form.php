<?php
$title = "Update Form";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/db_connect.inc');


if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "select * from country where countryid = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        exit("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $results = $stmt->get_result();
    foreach ($results as $row) {
        ?>
        <form method="post" action="update.php" enctype="multipart/form-data">

            <h3> Update country:
                <?php echo $row['countryname'] ?>
            </h3>
            <input type="hidden" name="countryid" value="<?php echo $row['countryid'] ?>" />

            <label>Description</label>
            <textarea cols="50" rows="5" name="description"><?php echo $row['description'] ?></textarea>
            <label>Select an Image:</label>
            <input type="file" name="image" /><span><?php echo $row['image'] ?></span>
            <input type="submit" name="submit" value="Update" />
        </form>
        <?php

    }
}
include('includes/footer.inc');
?>