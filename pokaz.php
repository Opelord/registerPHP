<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>Rejestracja</title>
	</head>
	<body>
		<h1>Grupy</h1>
		<?php
		
		require "funkcje.php";
		$conn = polaczenie();
		mysqli_query($conn,'SET NAMES utf8');
		
		$sql = "SELECT * FROM przedmioty";
		$result = kwerenda($conn, $sql);
		$przedmioty = array(); $x = 0;
		while ($row = mysqli_fetch_assoc($result)){
			$przedmioty[] = $row;
			$x++;
		}
		
		for ($i = 0; $i < $x; $i++){
			echo "<h2>".$przedmioty[$i]['nazwy']."</h2>";
			$sql = "SELECT id, grupa FROM grupy 
				WHERE grupy.id_przedmiotu = ".$przedmioty[$i]['id'];
			$result = kwerenda($conn, $sql);
			$grupy = array();
			while ($row = mysqli_fetch_assoc($result)){
				$grupy[] = $row;
			}
			$maks = 0;
			$grupyfin = array();
			for ($j = 0; $j < count($grupy); $j++){
				$grupyfin[$j][0] = $grupy[$j]['grupa'];
				$sql = "SELECT imie, nazwisko FROM osoby WHERE osoby.".$przedmioty[$i]['nazwy2']." = ".$grupy[$j]['id'];
				$result = kwerenda($conn, $sql);
				while ($row = mysqli_fetch_assoc($result)){
					$grupyfin[$j][] = $row['imie']." ".$row['nazwisko'];
				}
				if (count($grupyfin[$j]) > $maks){
					$maks = count($grupyfin[$j]);
				}
			}
			
			echo "<table>";
			for ($k = 0; $k < $maks; $k++){
				echo "<tr>";
				for ($j = 0; $j < count($grupyfin); $j++){
					echo "<td>";
					if(isset($grupyfin[$j][$k])){
						echo $grupyfin[$j][$k];
					}
					else 
						echo "";
					echo "</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
		}
		
		mysqli_close($conn);
		?>
	</body>
</html>