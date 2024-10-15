<?php
	$koneksi = new mysqli("localhost:3307", "root", "", "esport");

	if ($koneksi -> connect_errno) {
		echo "Koneksi ke Database Failed", $koneksi -> connect_errno;
	}

	if (isset($_GET['idgame'])) {
		$idgame = $_GET['idgame'];

		$sql = "SELECT * FROM game WHERE idgame = ?";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("i", $idgame);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
	}

	if (isset($_POST['submit'])) {
		$idgame = $_POST['idgame'];
		$name = $_POST['name'];
		$description = $_POST['description'];

		$sql = "UPDATE game SET name = ?, description = ? WHERE idgame = ?";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("ssi", $name, $description, $idgame);
		$stmt->execute();

		$koneksi->close();
		header("Location: game.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Game</title>
	<link rel="stylesheet" href="gameAddEdit.css">
</head>
<body>
	<h2>EDIT GAME</h2>
	<form action="" method="POST">
		<input type="hidden" name="idgame" value="<?php echo $row['idgame']; ?>">
		<label>Nama Game:</label><br>
		<input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>
		<label>Deskripsi:</label><br>
		<input type="text" name="description" value="<?php echo $row['description']; ?>"><br><br>
		<input type="submit" name="submit" value="Update">
	</form>
</body>
</html>
