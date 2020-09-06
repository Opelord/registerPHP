<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf8">
    <title>Overlap</title>
</head>
<body>
<?php	
	// Overlapping groups
	require 'funkcje.php';
	$conn = polaczenie();
	mysqli_query($conn,'SET NAMES utf8');
	
	$sql = "SELECT * FROM `przedmioty`";
	$result = kwerenda($conn,$sql);
	$przedmioty = array();
	while($row = mysqli_fetch_assoc($result)){
		$przedmioty[$row['id']] = $row['nazwy'];
	}
	
	echo "<form action = 'grupa.php'>";

		echo "<select name = 'overlap1'>";
			$sql = "SELECT * FROM `grupy`";
			$result = kwerenda($conn,$sql);
			while($row = mysqli_fetch_assoc($result)){
				echo "<option value=".$row['id']." >".$przedmioty[$row['id_przedmiotu']]." ".$row['grupa']."</option>";
			}
		echo "</select>";

		echo "<select name = 'overlap2'>";
			$sql = "SELECT * FROM `grupy`";
			$result = kwerenda($conn,$sql);
			while($row = mysqli_fetch_assoc($result)){
				echo "<option value=".$row['id']." >".$przedmioty[$row['id_przedmiotu']]." ".$row['grupa']."</option>";
			}
		echo "</select>  ";

		echo "<input type = 'submit' value = 'dodaj overlap'>";
	
	echo "</form>";
	mysqli_close($conn);
	
	// powrot do panelu admina
	echo "<form action = 'admin.php'>";
	echo "<input type = \"submit\" value = \"Panel admina\">";
	echo "</form>";	
?>
</body>
</html>