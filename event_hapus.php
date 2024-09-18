<?php
	$koneksi = new mysqli("localhost:3307", "root", "", "esport");

	if ($koneksi -> connect_errno) {
		echo "Koneksi ke Database Failed", $koneksi -> connect_errno;
	}

	if (isset($_POST['idevent'])) {
		$idevent = $_POST['idevent'];

		$sql = "DELETE FROM event WHERE idevent = ?";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("i", $idevent);
		$stmt->execute();

		$koneksi->close();
		header("Location: event.php");
	}
?>
