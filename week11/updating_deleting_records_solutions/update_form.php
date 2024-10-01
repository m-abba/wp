<?php
require_once('includes/db_connect.inc');
$title = "Update Form";
include('includes/header.inc');
include('includes/nav.inc');
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "select * from country where countryid=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        exit("prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $records = $stmt->get_result();
    foreach ($records as $row) {
?>
        <form class="main-form" method="post" action="update.php" enctype="multipart/form-data">
            <h3>Update country details: <?php echo $row['countryname'] ?> </h3>
            <input type="hidden" name="countryid" value="<?php echo $row['countryid'] ?>">
            <label>Description</label>
            <textarea cols="50" rows="10" name="description"><?php echo $row['description'] ?></textarea>
            <input type="file" name="image" id="image"><span><?php echo $row['image'] ?></span>
            <label>Caption</label>
            <input type="text" name="caption" value="<?php echo $row['caption'] ?>" size="50">
            <input type="submit" name="submit" value="Update" />
        </form>
<?php
    }
}
include('includes/footer.inc');
?>