<?php

function polaczenie() {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "rejestracja";
	
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	if(!$conn){
		die("Connection failed: ".mysqli_connect_error());
	}
	
	return $conn;
}

function doTab($result) {
	if($result){
        $tab = array();
        while ($row = mysqli_fetch_array($result)) {
			$tab[] = $row;
		}
        return $tab;
    }
    else
        return 0;
}

function zamiana($tekst) {
	$wynik = strtr($tekst, 'ĘÓĄŚŁŻŹĆŃęóąśłżźćń', 'eoaslzzcneoaslzzcn');
	$wynik = preg_replace('/\s+/', '', $wynik);
	return $wynik;
}

function str2url( $str, $strtolower = true )
{
	// konwersja znaków utf do znaków podstawowych;
	$str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);

	// Niektóre francuskie i niemieckie litery pozostawiają po takiej konwersji (jak powyżej) 
	// dodatkowe znaki. Poniższe dwie linijki te znaki wycinają; 
	$charsArr =  array( '^', '\'', '"', '`', '~');
	$str = str_replace( $charsArr, '', $str );

	$str = preg_replace( "/[^a-z0-1-]{1}/i", '_', $str );
	while( strcmp($str, $str = str_replace( array('__', '--'), array('_', '-'), $str)) != 0 );
	return $strtolower ? strtolower( $str ) : $str;
}  

function kwerenda($conn,$sql){
	if ($result = mysqli_query($conn,$sql)) {
	}
	else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn)."<br>";
	}
	return $result;	
}

function get_column_names($conn, $table_name) {
 
    $query = "SHOW COLUMNS FROM {$table_name}";
 
    if(($result=mysqli_query($conn,$query))) {
 
        /* Store the column names retrieved in an array */
        $column_names = array();
        while ($row = mysqli_fetch_array($result)) {
            $column_names[] = $row['Field'];
        }
 
        return $column_names;
    }
    else
        return 0;
}
?>