<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf8">
    <title>Admin</title>
</head>
<body>
<?php
	echo "<form action = \"tworzenie.php\">";
	echo "<input type = \"submit\" name = \"stworz\" value = \"Stwórz\">";
	echo "</form>";
?>
<h2>
Dodaj Przedmioty
</h2>

<form>
	Ile przedmiotów: 
	<input type="text" name="ile"><br>
	<input type="submit" value="dalej"><br>
</form>

<?php
	require 'funkcje.php';
	if(empty($_GET["ile"])){
		$ile = 0;
	}
	else{
		$ile = $_GET["ile"];
	}
	if($ile){
		echo "<form action = 'dodaj.php'>";
		for($i=1;$i<=$ile;$i++){
			echo "Przedmiot nr ".$i.": ";
			echo "<input type=\"text\" name=\"przedmiot".$i."\"><br>";
			for($x = 1; $x<=5; $x++){
				echo "Przedmiot ".$i.", grupa nr ".$x.":    ";
				echo "<input type=\"text\" name=\"grupa".$i.$x."\">,   ";
				echo "liczba miejsc: ";
				echo "<input type=\"text\" name=\"granica".$i.$x."\"><br>";
			}
		}
		echo "<input type=\"hidden\" name=\"ile\" value=\"".$ile."\">";
		echo "<input type=\"submit\" value=\"dalej\"><br>";
		echo "</form>";
	}
	// czyszczenie
	echo "<br>";
	echo "<form action = \"czyszczenie.php\">";
	echo "<input type = \"submit\" name = \"clear\" value = \"Wyczyść\">";
	echo "</form>";
	echo "<br>";
	// overlapping
	echo "<form action = 'overlap.php'>";
	echo "<input type = \"submit\" name = \"overlap\" value = \"Rozpocznij overlapping\">";
	echo "</form><br>";	
	// strona główna
	echo "<form action = 'index.php'>";
	echo "<input type = \"submit\" value = \"Strona główna\">";
	echo "</form><br>";	
	?>

</body>
</html>