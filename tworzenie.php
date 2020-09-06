<?php header( "refresh:5;url=admin.php" );?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf8">
    <title>Tworzenie</title>
</head>
<body>
<?php
		require 'funkcje.php';
		$conn = polaczenie();
		mysqli_query($conn,'SET NAMES utf8');
		
		$sql = "CREATE TABLE `przedmioty` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`nazwy` text COLLATE utf8_general_ci NOT NULL,
		`nazwy2` text COLLATE utf8_general_ci NOT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
		kwerenda($conn,$sql);
		echo "Utworzono tabelę 'przedmioty'.";
		
		$sql= "CREATE TABLE `grupy` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`id_przedmiotu` int(11) NOT NULL,
		`grupa` varchar(30) COLLATE utf8_general_ci NOT NULL,
		`granica` int(11) NOT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
		kwerenda($conn,$sql);
		echo "Utworzono tabelę 'grupy'.";
		
		$sql = "CREATE TABLE `osoby` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`imie` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		`nazwisko` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
		kwerenda($conn,$sql);
		echo "Utworzono tabelę 'osoby'.";
		
		$sql = "INSERT INTO `osoby` (`id`, `imie`, `nazwisko`) VALUES
		(NULL, 'konkretne imie', 'i konkretne nazwisko')"; // <----
		// kopiujac ten wiersz wpisz wszystkie osoby na kierunku 
		// maly kierunek, wiec nie widzialem potrzeby pisania funkcji
		kwerenda($conn, $sql);
		echo "Uzupełniono tabelę osoby<br>";
		// ,,overlap" to przedmioty i grupy, ktore sa w tym samym czasie
		$sql = "CREATE TABLE `overlap` (
		`id_grup` text CHARACTER SET utf8 NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
		kwerenda($conn,$sql);
		echo "Utworzono tabelę overlap<br>";
		
		mysqli_close($conn);
?>
</body>
</html>