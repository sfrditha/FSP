<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>INSERT ACHIEVEMENT</title>
    <style type="text/css">
		label 
		{
			display: inline-block;
			width: 80px;
		}
	</style>
</head>
<body>
    <b>Insert New Achievement Here</b><br><br>

    <?php
		$koneksi = new mysqli("localhost:3307", "root", "", "esport");

		if ($koneksi -> connect_errno) {
			echo "Koneksi ke Database Failed", $koneksi -> connect_errno;
		}

		// Cek apakah form telah disubmit
		if (isset($_POST['submit'])) {
			$teamid = $_POST['team'];
			$name = $_POST['name'];
			$date = $_POST['date'];
			$deskripsi = $_POST['deskripsi'];

			// Prepare dan insert data ke tabel 'achievement'
			$sql = "INSERT INTO achievement (idteam, name, date, description) VALUES (?, ?, ?, ?)";
			$stmt = $koneksi->prepare($sql);
			$stmt->bind_param("isss", $teamid, $name, $date, $deskripsi);

			if ($stmt->execute()) {
				// Jika berhasil, redirect ke halaman achievement.php
				header("Location: achievement.php");
				exit();
			} else {
				echo "<p style='color: red;'>Gagal menambahkan achievement: " . $koneksi->error . "</p>";
			}
		}
	?>

    <form method="post" enctype="multipart/form-data" action="">
		<label>NamaTeam</label>
		<link rel="stylesheet" href="achievementAddEdit.css">
		<?php
			// Ambil data tim untuk dropdown
			$sql = "SELECT * FROM team";
			$stmt = $koneksi->prepare($sql);
			$stmt->execute();
			$result = $stmt->get_result();

			echo "<select name='team' id='team-dropdown'>";
			// Loop through the results dan buat option untuk setiap tim
			while ($row = $result->fetch_assoc()) {
				$val = $row['idteam'];
				$text = $row['name'];
				echo "<option value='$val'>$text</option>";
			}
			echo "</select>";
		?><br><br>

		<label>Kejuaraan</label>
		<input type="text" name="name" required><br><br>

		<label>Tanggal</label>
		<input type="date" name="date" required><br><br>

		<label>Deskripsi</label>
		<textarea name="deskripsi" rows="4" cols="50" placeholder="Masukan Deskripsi" required></textarea><br><br>

		<input type="submit" name="submit" value="Insert Achievement"><br>
	</form>

    <?php
    $koneksi->close();
    ?>
</body>
</html>
