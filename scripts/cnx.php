<?php

$servername 	= "127.0.0.1";
$benutzername 	= "sast_academy";
$kennwort 		= "root_123456789";
$datenbanken 	= "sast_academy";

$servername2 	= "127.0.0.1";
$benutzername2 	= "sast_old";
$kennwort2 		= "root_123456789";
$datenbanken2 	= "sast_old_academy";


$new  =  mysqli_connect($servername, $benutzername, $kennwort, $datenbanken);
$old  =  mysqli_connect($servername2, $benutzername2, $kennwort2, $datenbanken2);

if (!$new) {

	echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	exit;

} else {

	mysqli_query($new,
		"SET character_set_results = 'utf8', 
		character_set_client = 'utf8', 
		character_set_connection = 'utf8', 
		character_set_database = 'utf8', 
		character_set_server = 'utf8'");


	mysqli_query($old,
		"SET character_set_results = 'utf8', 
		character_set_client = 'utf8', 
		character_set_connection = 'utf8', 
		character_set_database = 'utf8', 
		character_set_server = 'utf8'");

	

	
}
?>