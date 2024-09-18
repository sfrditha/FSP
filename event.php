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
	<title>Event</title>
	<link rel="stylesheet" href="event.css">
</head>
<body>
	<h2>Event</h2>

	<?php
		$sql = "SELECT * FROM event";
		$stmt = $koneksi->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();

		echo "<table border='1'>";
		echo "<tr><th>IDEvent</th><th>Name</th><th>Date</th><th>Description</th><th colspan='2'>Aksi</th></tr>";

		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			echo "<td>" . $row['idevent'] . "</td>";
			echo "<td>" . $row['name'] . "</td>";
			echo "<td>" . $row['date'] . "</td>";
			echo "<td>" . $row['description'] . "</td>";
			echo "<td>
					<form action='event_hapus.php' method='POST'>
						<input type='hidden' name='idevent' value='" . $row['idevent'] . "'>
						<input type='submit' value='Hapus'>
					</form>
				  </td>";
			echo "<td>
					<a href='event_edit.php?idevent=" . $row['idevent'] . "'>
						<button>Edit</button>
					</a>
				  </td>";
			echo "</tr>";
		}
		echo "</table>";

		$koneksi->close();
	?>
	<br>
	<a href="event_insert.php">
		<button>Tambah Event</button>
	</a>
	<br><br>
	<a href="home.php">Back To Home</a>
</body>
</html>
