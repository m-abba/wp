<?php
$title = "Update Confirmation";
include('includes/header.inc');
include('includes/nav.inc');
require_once('includes/db_connect.inc');

echo "<div id='message'>";
$error = false;
if (!empty($_POST['countryid'])) {

	foreach ($_POST as $key => $val) {
		$$key = trim($val);
	}
	$image = $_FILES['image']['name'];
	$temp = $_FILES['image']['tmp_name'];

	$sql = "select * from country where countryid=?";
	$stmt = $conn->prepare($sql);
	if (!$stmt) {
		exit("prepare failed: " . $conn->error);
	}
	$stmt->bind_param("i", $countryid);
	$stmt->execute();
	$records = $stmt->get_result();
	if ($records->num_rows > 0) {
		foreach ($records as $row) {
			$countryname = $row['countryname'];
			$oldimage = $row['image'];
		}
	}
	if (empty($image)) {
		$image = $oldimage;
	}
	$sql = "UPDATE country SET description=?,image=?, caption=? WHERE countryid=?";

	$stmt = $conn->prepare($sql);

	if (!$stmt) {
		exit("prepare failed: " . $conn->error);
	}

	$stmt->bind_param("sssi", $description, $image, $caption, $countryid);
	$stmt->execute();
	if ($stmt->affected_rows > 0) {
		echo "<p>Record $countryname updated<p>";

		if ($oldimage != $image) {
			//Delete old image
			if (file_exists('images/' . $oldimage)) {
				unlink('images/' . $oldimage);
			}
			//Upload new one
			if (move_uploaded_file($temp, 'images/' . $image)) {
				echo "Image moved to folder";
			} else {
				echo "Image not moved to folder";
			}
		}
	} else {
		$error = true;
	}
} else {
	$error = true;
}
if ($error) {
	echo "<p>Record NOT updated<p>";
}

echo "</div>";

include('includes/footer.inc');
