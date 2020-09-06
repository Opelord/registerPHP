<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>Rejestracja</title>
	</head>
	<body>
		<h1>Rejestracja na przedmioty</h1>
		<h2>semestr letni 2018/2019</h2>
		<?php
		echo "<form method = \"post\" action = \"wynik.php\">";
		
			require "funkcje.php";
			$conn = polaczenie();
			mysqli_query($conn,'SET NAMES utf8');

			echo 'Imię i nazwisko:<br>';
			$sql = "SELECT * FROM osoby";
			$result = kwerenda($conn,$sql);
			echo "<select name = 'kto'>";
			echo "<option value = 0>    </option>";
			$kto = array(
						'id' => array(),
						'imie' => array(),
						'nazwisko' => array()
						);
			$x = 0;
			while ($row = mysqli_fetch_assoc($result)){
							$kto['id'][$x] = $row['id'];
							$kto['imie'][$x] = $row['imie'];
							$kto['nazwisko'][$x++] = $row['nazwisko'];
			}
			array_multisort($kto['nazwisko'],SORT_ASC,SORT_STRING,
							$kto['imie'],SORT_ASC,SORT_STRING,
							$kto['id'],SORT_ASC,SORT_NUMERIC);
			for($i = 0; $i < count($kto['id']); $i++){ 
				echo "<option value=".$kto['id'][$i].">".$kto['imie'][$i]." ".$kto['nazwisko'][$i]."</option>";
			}
			echo "</select><br><br>";
			
			$sql = "SELECT * FROM przedmioty";
			$result = kwerenda($conn,$sql);
			
			$x = 1;
			while($row = mysqli_fetch_assoc($result)){
				echo $row['nazwy']."<br>";
				
				$sql = "SELECT * FROM grupy WHERE id_przedmiotu = ".$row['id'];
				$result2 = kwerenda($conn,$sql);
				echo "<select name = 'grupa".$x."'>";
				echo "<option value = 0>  </option>";
				while($row2 = mysqli_fetch_assoc($result2)){
					echo "<option value=".$row2['id']." >".$row2['grupa']."</option>";
				}
				echo "</select><br><br>";
				$x++;
			}
			
			echo "<button type = 'submit' name = 'rejestruj' value = 'Zarejestruj'>Zarejestruj</button><br>";
			echo "<button type = 'submit' name = 'pokazuj' value = 'Pokaż przedmioty, na które jestem zapisany'>Pokaż przedmioty, na które jestem zapisany</button>";
			mysqli_close($conn);
		echo "</form>";
		?>
	</body>
</html>