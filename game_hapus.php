<?php
	$koneksi = new mysqli("localhost:3307", "root", "", "esport");

	if ($koneksi -> connect_errno) {
		echo "Koneksi ke Database Failed", $koneksi -> connect_errno;
	}

	if (isset($_POST['idgame'])) {
		$idgame = $_POST['idgame'];

		$sql = "DELETE FROM game WHERE idgame = ?";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("i", $idgame);
		$stmt->execute();

		$koneksi->close();
		header("Location: game.php");
	}
?>
