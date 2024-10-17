<?php
	$koneksi = new mysqli("localhost:3306", "root", "", "esport");

	if ($koneksi -> connect_errno) {
		echo "Koneksi ke Database Failed", $koneksi -> connect_errno;
	}

	if (isset($_GET['idteam'])) {
		$idteam = $_GET['idteam'];

		// Ambil data team berdasarkan idteam
		$sql = "SELECT * FROM team WHERE idteam = ?";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("i", $idteam);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
	}

	if (isset($_POST['submit'])) {
		$idteam = $_POST['idteam'];
		$idgame = $_POST['idgame'];
		$team_name = $_POST['name'];

		$sql = "UPDATE team SET idgame = ?, name = ? WHERE idteam = ?";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("isi", $idgame, $team_name, $idteam);
		$stmt->execute();

		$koneksi->close();
		header("Location: team.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Team</title>
	<link rel="stylesheet" href="teamAdEditt.css">
</head>
<body>
	<h2>EDIT TEAM</h2>

	<form edit action="" method="POST">
		<input type="hidden" name="idteam" value="<?php echo $row['idteam']; ?>">

		<label for="idgame">Game:</label><br>
		<select name="idgame">
			<?php
				
				$sql = "SELECT idgame, name FROM game";
				$result = $koneksi->query($sql);

				while ($game_row = $result->fetch_assoc()) {
					$selected = $game_row['idgame'] == $row['idgame'] ? "selected" : "";
					echo "<option value='" . $game_row['idgame'] . "' $selected>" . $game_row['name'] . "</option>";
				}
			?>
		</select><br><br>

		<label for="name">Team Name:</label><br>
		<input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>

		<input type="submit" name="submit" value="Update">
	</form>
	<a href="home.php">Back to Home</a>
</body>
</html>
