<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf8">
    <title>Overlap</title>
</head>
<body>
<?php	
	require 'funkcje.php';
	$conn = polaczenie();
	mysqli_query($conn,'SET NAMES utf8');
	
	$kto = $_POST['kto'];
	$x = 1;
	$ile = 0;
	$wyjatki = array();
	while (isset($_POST['grupa'.$x])){
		$ile++;
		if ($_POST['grupa'.$x] == 0){
			$wyjatki[] = $x;
		}
	}
	
	// czy jest cos o value 0
	
	// czy sa overlapy
	
	$sql = "INSERT INTO ";
	$result = kwerenda($conn,$sql);
	$result = doTab($result);
	
	// czy jest 
	mysqli_close($conn);
	
	// powrot do panelu admina
	echo "<form action = 'index.php'>";
	echo "<input type = \"submit\" value = \"Strona główna\">";
	echo "</form>";	
?>
</body>
</html>