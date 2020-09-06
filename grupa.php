<?php header( "refresh:5;url=overlap.php" );?>
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
	$over1 = $_GET['overlap1'];
	$over2 = $_GET['overlap2'];
	if ($over1 < $over2){
		$sql = "INSERT INTO `overlap` (`id_grup`) VALUES ('".$over1." ".$over2."')";
	}
	else{
		$sql = "INSERT INTO `overlap` (`id_grup`) VALUES ('".$over2." ".$over1."')";
	}
	kwerenda($conn,$sql);
	mysqli_close($conn);
	
	echo "Strona powróci do panelu admina za 5 sekund";
?>

</body>
</html>