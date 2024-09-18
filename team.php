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
	<title>Team</title>
	<link rel="stylesheet" href="team.css">
</head>
<body>
	<h2>Team</h2>

	<?php
		
		$sql = "SELECT team.idteam, game.name AS game_name, team.name AS team_name
				FROM team
				INNER JOIN game ON team.idgame = game.idgame";
		$stmt = $koneksi->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();

		echo "<table border='1'>";
		echo "<tr><th>IDTeam</th><th>Game</th><th>Team Name</th><th colspan='2'>Aksi</th></tr>";

		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			echo "<td>" . $row['idteam'] . "</td>";
			echo "<td>" . $row['game_name'] . "</td>";  
			echo "<td>" . $row['team_name'] . "</td>";
			echo "<td>
					<form action='team_hapus.php' method='POST'>
						<input type='hidden' name='idteam' value='" . $row['idteam'] . "'>
						<input type='submit' value='Hapus'>
					</form>
				  </td>";
			echo "<td>
					<a href='team_edit.php?idteam=" . $row['idteam'] . "'>
						<button>Edit</button>
					</a>
				  </td>";
			echo "</tr>";
		}
		echo "</table>";

		$koneksi->close();
	?>
	<br>
	<a href="team_insert.php">
		<button>Tambah Team</button>
	</a>
	<br><br>
	<a href="home.php">Back To Home</a>
</body>
</html>
