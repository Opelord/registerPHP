<?php header( "refresh:5;url=admin.php" );?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf8">
    <title>Czyszczenie</title>
</head>
<body>
<?php
		require 'funkcje.php';
		// usuwanie wszystkiego z tabeli przedmioty
		$conn = polaczenie();
		mysqli_query($conn,'SET NAMES utf8');
		$sql = "TRUNCATE TABLE przedmioty";
		kwerenda($conn,$sql);
		
		//USUWAnie wszystkiego z tabeli grupy
		$sql = "TRUNCATE TABLE grupy";
		kwerenda($conn,$sql);
		
		// usuwanie kolumn z przedmiotami w tabeli osoby
		$column_names = get_column_names($conn, 'osoby');
		for($i = 3;$i < count($column_names); $i++){ 
			$sql = "ALTER TABLE osoby DROP `".$column_names[$i]."`";
			if (mysqli_query($conn,$sql)) {
				echo "Usunięto przedmiot \"".$column_names[$i]."\" w \"Osobach\"<br>";
			}
			else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn)."<br>";
			}
		}
		mysqli_close($conn);
?>
</body>
</html>