<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf8">
    <title>Dodawanie</title>
</head>
<body>

<?php
	require 'funkcje.php';
	$conn = polaczenie();
	mysqli_query($conn,'SET NAMES utf8');
	
	$ile=$_GET["ile"];
	
	for($i=1; $i<=$ile; $i++){
		$x=1;
		$nazwa = $_GET["przedmiot".$i];
		echo $nazwa."<br>";
		$nazwa2 = str2url($nazwa);
		$sql = "INSERT INTO przedmioty (nazwy,nazwy2) VALUES ('".$nazwa."', '".$nazwa2."')";
		kwerenda($conn,$sql);
		$sql = "SELECT id FROM przedmioty WHERE nazwy = '".$nazwa."'";
		$result = kwerenda($conn,$sql);
		$idprzedm = doTab($result);
		
		while(!empty($_GET["grupa".$i.$x])){
			$grupa = $_GET["grupa".$i.$x];
			$granica = $_GET["granica".$i.$x];
			$sql = "INSERT INTO grupy (id_przedmiotu,grupa,granica) VALUES (".$idprzedm[0][0].",'".$grupa."','".$granica."')";
			if (mysqli_query($conn,$sql)) {
				echo "Udało się wpisać ".$nazwa.$i.$x.".<br>";
			}
			else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn)."<br>";
			}
			$x++;
		}		
		$sql = "ALTER TABLE `osoby` ADD `".$nazwa2."` int(11)";
		if (mysqli_query($conn,$sql)) {
			echo "Udało się wpisać ".$nazwa.".<br>";
		}
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn)."<br>";
		}
		$sql = "UPDATE `osoby` SET `".$nazwa2."` = 0";
		if (mysqli_query($conn,$sql)) {
			echo "Wszystko w tej tabeli jest zerem";
		}
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn)."<br>";
		}
	}

	mysqli_close($conn);
?>

</body>
</html>