<?php
    $koneksi = new mysqli("localhost:3307","root","","esport"); 

	if ($koneksi -> connect_errno)
	{
		echo "Koneksi ke Database Failed", $koneksi -> connect_errno;
		exit();
	}
	// echo "Koneksi sukses. <br>";

	$koneksi->close();
    
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>eSport Website</title>
	<link rel="stylesheet" type="text/css" href="homee.css"> <!-- Link to the CSS file -->
	<script type="text/javascript">
		// Alert to show connection success
		window.onload = function() {
			alert("Koneksi sukses.");
		};
	</script>
</head>
<body>
	
    <h1>WELCOME!</h1> <!-- Menambahkan judul WELCOME -->
    <ul>
        <li> <a href="team.php"> TEAM </a> </li>
        <li> <a href="game.php"> GAME </a> </li>
        <li> <a href="event.php"> EVENT </a> </li>
        <li> <a href="achievement.php"> ACHIEVEMENT </a> </li>
    </ul>
</body>
</html>