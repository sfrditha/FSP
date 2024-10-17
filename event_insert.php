<?php
	$koneksi = new mysqli("localhost:3307", "root", "", "esport");

	if ($koneksi -> connect_errno) {
		echo "Koneksi ke Database Failed", $koneksi -> connect_errno;
	}

	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$date = $_POST['date'];
		$description = $_POST['description'];

		$sql = "INSERT INTO event (name, date, description) VALUES (?, ?, ?)";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("sss", $name, $date, $description);
		$stmt->execute();

		$koneksi->close();
		header("Location: event.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tambah Event</title>
	<link rel="stylesheet" href="eventAdEditt.css">
</head>
<body>
	<h2>TAMBAH EVENT</h2>
	<form action="" method="POST">
		<label>Nama Event:</label><br>
		<input type="text" name="name"><br><br>
		<label>Tanggal:</label><br>
		<input type="date" name="date"><br><br>
		<label>Deskripsi:</label><br>
		<input type="text" name="description"><br><br>
		<input type="submit" name="submit" value="Simpan">
	</form>
</body>
</html>
