<?php
	$koneksi = new mysqli("localhost:3307", "root", "", "esport");

	if ($koneksi -> connect_errno) {
		echo "Koneksi ke Database Failed", $koneksi -> connect_errno;
	}

	if (isset($_POST['idteam'])) {
		$idteam = $_POST['idteam'];

		$sql = "DELETE FROM team WHERE idteam = ?";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("i", $idteam);
		$stmt->execute();

		$koneksi->close();

		header("Location: team.php");
	}
?>
