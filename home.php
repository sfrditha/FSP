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

		function toggleDropdown() {
			var dropdown = document.getElementById("dropdown");
			dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
		}
	</script>
</head>
<body>
	
    <h1>WELCOME!</h1> <!-- Menambahkan judul WELCOME -->
    
    <div style="position: absolute; top: 40px; right: 40px;">
        <img src="user.png" alt="Profile" style="width: 40px; height: 40px;" style="cursor: pointer;" onclick="toggleDropdown()">
        <div id="dropdown" style="display: none;">
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>

    <ul>
        <li> <a href="team.php"> TEAM </a> </li>
        <li> <a href="game.php"> GAME </a> </li>
        <li> <a href="event.php"> EVENT </a> </li>
        <li> <a href="achievement.php"> ACHIEVEMENT </a> </li>
    </ul>
</body>
</html>
