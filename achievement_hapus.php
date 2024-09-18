<?php
	$koneksi = new mysqli("localhost:3307","root","","esport"); 

	if ($koneksi -> connect_errno)
	{
		echo "Koneksi ke Database Failed", $koneksi -> connect_errno;
	}

	if (isset($_POST['idachievement'])) {
		$idachievement = $_POST['idachievement'];

		// Query untuk menghapus data berdasarkan idachievement
		$sql = "DELETE FROM achievement WHERE idachievement = ?";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("i", $idachievement);
		$stmt->execute();

		if ($stmt) {
			echo "Data berhasil dihapus.";
		} else {
			echo "Error dalam menghapus data.";
		}

		$koneksi->close();
	}

	// Redirect kembali ke halaman achievement
	header("Location: achievement.php");
?>
