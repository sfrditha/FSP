<?php
	$koneksi = new mysqli("localhost:3307", "root", "", "esport");

	if ($koneksi -> connect_errno) {
		echo "Koneksi ke Database Failed", $koneksi -> connect_errno;
	}

	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$description = $_POST['description'];

		$sql = "INSERT INTO game (name, description) VALUES (?, ?)";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("ss", $name, $description);
		$stmt->execute();

		$koneksi->close();
		header("Location: game.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tambah Game</title>
	<link rel="stylesheet" href="gameAddEdit.css">
</head>
<body>
	<h2>TAMBAH GAME</h2>
	<form action="" method="POST">
		<label>Nama Game:</label><br>
		<input type="text" name="name"><br><br>
		<label>Deskripsi:</label><br>
		<input type="text" name="description"><br><br>
		<input type="submit" name="submit" value="Simpan">
	</form>
</body>
</html>
