<?php
	$koneksi = new mysqli("localhost:3306", "root", "", "esport");

	if ($koneksi -> connect_errno) {
		echo "Koneksi ke Database Failed", $koneksi -> connect_errno;
	}

	if (isset($_POST['submit'])) {
		$idgame = $_POST['idgame'];
		$team_name = $_POST['name'];

		$sql = "INSERT INTO team (idgame, name) VALUES (?, ?)";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("is", $idgame, $team_name);
		$stmt->execute();

		$koneksi->close();
		header("Location: team.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tambah Team</title>
	<link rel="stylesheet" href="team.css">
</head>
<body>
	<h2>Tambah Team</h2>

	<form action="" method="POST">
		<label for="idgame">Game:</label><br>
		<select name="idgame">
			<?php
				
				$sql = "SELECT idgame, name FROM game";
				$result = $koneksi->query($sql);

				while ($row = $result->fetch_assoc()) {
					echo "<option value='" . $row['idgame'] . "'>" . $row['name'] . "</option>";
				}
			?>
		</select><br><br>

		<label for="name">Team Name:</label><br>
		<input type="text" name="name"><br><br>

		<input type="submit" name="submit" value="Simpan">
	</form>
</body>
</html>
