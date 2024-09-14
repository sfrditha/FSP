<?php
	$koneksi = new mysqli("localhost", "root", "", "esport");

	if ($koneksi -> connect_errno) {
		echo "Koneksi ke Database Failed", $koneksi -> connect_errno;
	}

	if (isset($_GET['idevent'])) {
		$idevent = $_GET['idevent'];

		$sql = "SELECT * FROM event WHERE idevent = ?";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("i", $idevent);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
	}

	if (isset($_POST['submit'])) {
		$idevent = $_POST['idevent'];
		$name = $_POST['name'];
		$date = $_POST['date'];
		$description = $_POST['description'];

		$sql = "UPDATE event SET name = ?, date = ?, description = ? WHERE idevent = ?";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("sssi", $name, $date, $description, $idevent);
		$stmt->execute();

		$koneksi->close();
		header("Location: event.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Event</title>
</head>
<body>
	<h2>Edit Event</h2>
	<form action="" method="POST">
		<input type="hidden" name="idevent" value="<?php echo $row['idevent']; ?>">
		<label>Nama Event:</label><br>
		<input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>
		<label>Tanggal:</label><br>
		<input type="date" name="date" value="<?php echo $row['date']; ?>"><br><br>
		<label>Deskripsi:</label><br>
		<input type="text" name="description" value="<?php echo $row['description']; ?>"><br><br>
		<input type="submit" name="submit" value="Update">
	</form>
</body>
</html>
