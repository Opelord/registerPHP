<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Wynik rejestracji</title>
</head>
<body>
<?php	
	require 'funkcje.php';
	$conn = polaczenie();
	mysqli_query($conn,'SET NAMES utf8');
	$kto = $_POST['kto'];
	if($kto == 0){
		echo "Cofnij się i podaj osobę.<br>";
	}
	else{
		if (isset($_POST['rejestruj'])){
			$x = 1;
			$grupy = array();
			while (isset($_POST['grupa'.$x])){
				$grupy[] = $_POST['grupa'.$x];
				$x++;
			}
			$ile = $x - 1;
			
			// czy sa overlapy

			$sql = "SELECT * FROM osoby WHERE id = ".$kto;
			$result = kwerenda($conn, $sql);
			$daneosoby = mysqli_fetch_array($result);
			
			$sql = "SELECT `nazwy2` FROM `przedmioty`";
			$result = kwerenda($conn,$sql);
			$nazwyprzedm = doTab($result);
			
			$sqlprep = "";
			for ($i = 3; $i < count($daneosoby)/2; $i++){
				if ( $daneosoby[$i] != $grupy[$i-3]){
    			    if ( $daneosoby[$i] != 0 && $grupy[$i-3] != 0 ){ 
				    	$sqlprep .= "UPDATE grupy SET granica = granica + 1 WHERE id = ".$daneosoby[$i]."; ";
				    }
				}
			}
			
			$tempgrup = array();
			for ($i = 3; $i < count($daneosoby)/2; $i++){
				if (($daneosoby[$i] != 0) && ($grupy[$i-3] == 0)){
					$tempgrup[] = $daneosoby[$i];
				}
				else {
					$tempgrup[] = $grupy[$i-3];
				}
			}
			
			$sql = "SELECT * FROM overlap";
			$result = kwerenda($conn,$sql);
			$result = doTab($result);
			$overlapy = count($result);
			
			$czysaoverlapy = array();
			
			for($i = 0; $i < $ile-1; $i++){
				for($j = $i+1; $j < $ile; $j++){
					$czy = $tempgrup[$i].' '.$tempgrup[$j];
					for ($k = 0; $k < $overlapy; $k++){
						$czysaoverlapy[] = in_array($czy, $result[$k]);
					}
				}
			}

			if(in_array(1,$czysaoverlapy)){
				echo "Zajęcia, które wybrałeś się pokrywają. Wybierz inne.";
			}
			else{
					
				// czytanie danych
				$danegrup = array();
				for($i = 0; $i < $ile; $i++){
					if (($grupy[$i] != 0)){
						$sql = "SELECT * FROM `grupy` WHERE `id` = ".$grupy[$i];
						$result = kwerenda($conn,$sql);
						$row = mysqli_fetch_assoc($result);
						$danegrup[] = $row;
					}
					else{
						// $danegrup[$i]['id_przedmiotu'] = $i+1;
						// $danegrup[$i]['id'] = 0;
						// $danegrup[$i]['granica'] = 1;
						$danegrup[$i] = 0;
					}
				}
			
				
				$sql1 = "";
				$sql2 = "";
				for ($i = 0; $i < $ile; $i++){
					if ($danegrup[$i] != 0){
						if ($grupy[$i] != $daneosoby[$i+3]){
							$sql1 = $sql1."UPDATE grupy 
								SET granica = ".($danegrup[$i]['granica'] - 1)." 
								WHERE id = ".$danegrup[$i]['id'].";";
							$sql2 = $sql2."UPDATE osoby 
								SET `".$nazwyprzedm[$i][0]."` = ".$danegrup[$i]['id']." 
								WHERE id = ".$kto.";";
							// echo $nazwyprzedm[$i][0]."<br>";
						}
					}
				}
				$sql = $sqlprep.$sql1." ".$sql2;
				
				$czymoznadodac = 1;
				for ($i = 0; $i < $ile; $i++){
					if ($danegrup[$i] != 0){
						if ($danegrup[$i]['granica'] <= 0){
							$czymoznadodac = 0;
							$x = $i;
							break;
						}
					}
				}
				
				if ($czymoznadodac == 1){
					//dodawanie
					if($result = mysqli_multi_query($conn,$sql)){
						echo "Zarejestrowano poprawnie!";
					}
					else {
						echo "Error: " . $sql . "<br>" . mysqli_error($conn)."<br>";
					}
				}
				else {
					$sql = "SELECT `nazwy` FROM `przedmioty` WHERE id = ".$danegrup[$x]['id_przedmiotu'];
					$result = kwerenda($conn,$sql);
					$result = doTab($result);
					echo "Nie powiodło się! Grupa ".$result[0][0]." ".$danegrup[$x]['grupa']." jest pełna.<br>";
					echo "Sprobuj innego przedmiotu. <br>";
				}

				// koniec dodawania do grup
			}
	
		}
		// pokaz grupy
		else if (isset($_POST['pokazuj'])){
			$kto = $_POST['kto'];
			if($kto == 0){
				echo "Cofnij się i podaj osobę.<br>";
			}
			else{
				$sql = "SELECT nazwy, nazwy2 FROM przedmioty";
				$result = kwerenda($conn, $sql);
				$sqlarr = array();
				$x=0;
				echo "<table><tr>";
				
				while ($row = mysqli_fetch_array($result)){
					$sqlarr[] = "SELECT grupy.* 
					FROM grupy
					INNER JOIN osoby ON osoby.".$row[1]." = grupy.id
					WHERE osoby.id = ".$kto;
					$x++;
					echo "<th>".$row[0]."</th>";
				}
				echo "</tr><tr>";
				for ($i = 0; $i < $x; $i++){
					echo "<td>";
						$result = kwerenda($conn, $sqlarr[$i]);
						$row = mysqli_fetch_array($result);
						if ($row[2] != 	""){
							echo $row[2];
						}
						else{
							echo "-";
						}
					echo "</td>";
				}
				echo "</tr></table>";
			}
		}
		else{
			echo "Nieprawidłowy submit";
		}
	}
	mysqli_close($conn);
	// powrot do panelu admina
	echo "<form action = 'index.php'>";
	echo "<input type = \"submit\" value = \"Strona główna\">";
	echo "</form>";	
?>
</body>
</html>