<?php
	$koneksi = new mysqli("localhost", "root", "", "esport");

	if ($koneksi -> connect_errno) {
		echo "Koneksi ke Database Failed", $koneksi -> connect_errno;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Game</title>
	<link rel="stylesheet" href="game.css">
</head>
<body>
	<h2>Game</h2>

	<?php
		$sql = "SELECT * FROM game";
		$stmt = $koneksi->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();

		echo "<table border='1'>";
		echo "<tr><th>IDGame</th><th>Name</th><th>Description</th><th colspan='2'>Aksi</th></tr>";

		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			echo "<td>" . $row['idgame'] . "</td>";
			echo "<td>" . $row['name'] . "</td>";
			echo "<td>" . $row['description'] . "</td>";
			echo "<td>
					<form action='game_hapus.php' method='POST'>
						<input type='hidden' name='idgame' value='" . $row['idgame'] . "'>
						<input type='submit' value='Hapus'>
					</form>
				  </td>";
			echo "<td>
					<a href='game_edit.php?idgame=" . $row['idgame'] . "'>
						<button>Edit</button>
					</a>
				  </td>";
			echo "</tr>";
		}
		echo "</table>";

		$koneksi->close();
	?>
	<br>
	<a href="game_insert.php">
		<button>Tambah Game</button>
	</a>
	<br><br>
	<a href="home.php">Back To Home</a>
</body>
</html>
