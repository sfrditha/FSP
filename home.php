<?php
    $koneksi = new mysqli("localhost","root","","esport"); 

	if ($koneksi -> connect_errno)
	{
		echo "Koneksi ke Database Failed", $koneksi -> connect_errno;
	}
	echo "Koneksi sukses. <br>";

	$koneksi->close();
    
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
    <ul>
        <li> <a href="team.php"> Team </a> </li>
        <li> <a href="game.php"> Game </a> </li>
        <li> <a href="event.php"> Event </a> </li>
        <li> <a href="achievement.php"> Achievement </a> </li>
    </ul>
</body>
</html>