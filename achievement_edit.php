<?php
	$koneksi = new mysqli("localhost","root","","esport"); 

	if ($koneksi -> connect_errno)
	{
		echo "Koneksi ke Database Failed", $koneksi -> connect_errno;
	}

	// Mendapatkan idachievement dari URL
	if (isset($_GET['idachievement'])) {
		$idachievement = $_GET['idachievement'];

		// Mengambil data berdasarkan idachievement
		$sql = "SELECT * FROM achievement WHERE idachievement = ?";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("i", $idachievement);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = $result->fetch_assoc();

		if ($data) {
			$idteam = $data['idteam'];
			$name = $data['name'];
			$date = $data['date'];
			$description = $data['description'];
		}
	}

	// Jika form disubmit untuk mengupdate data
	if (isset($_POST['submit'])) {
		$idachievement = $_POST['idachievement'];
		$idteam = $_POST['idteam'];
		$name = $_POST['name'];
		$date = $_POST['date'];
		$description = $_POST['description'];

		// Update data di database
		$sql = "UPDATE achievement SET idteam = ?, name = ?, date = ?, description = ? WHERE idachievement = ?";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("isssi", $idteam, $name, $date, $description, $idachievement);
		$stmt->execute();

		if ($stmt) {
			echo "Data berhasil diupdate.";
		} else {
			echo "Error dalam mengupdate data.";
		}

		// Redirect kembali ke halaman achievement
		header("Location: achievement.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Achievement</title>
</head>
<body>
	<h2>Edit Achievement</h2>
	<form action="achievement_edit.php" method="POST">
		<input type="hidden" name="idachievement" value="<?php echo $idachievement; ?>">
		<label>ID Team:</label><br>
		<input type="text" name="idteam" value="<?php echo $idteam; ?>"><br><br>
		<label>Name:</label><br>
		<input type="text" name="name" value="<?php echo $name; ?>"><br><br>
		<label>Date:</label><br>
		<input type="date" name="date" value="<?php echo $date; ?>"><br><br>
		<label>Description:</label><br>
		<textarea name="description"><?php echo $description; ?></textarea><br><br>
		<input type="submit" name="submit" value="Update">
	</form>
</body>
</html>
