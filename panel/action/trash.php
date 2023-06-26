<?php
// Initialize the session
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	
	// Include config file
	require_once ('../config/database.config.php');

	$id = $_GET['id'];
	if (isset($id)) {
		$horario = time();
		$nombreu = $_SESSION["username"];
		date_default_timezone_set("America/Argentina/Buenos_Aires");

		$sqlpub = ("SELECT name FROM retros WHERE id = '$id'");
		$resultpub = $link->query($sqlpub);
		$rowpub = mysqli_fetch_array($resultpub);
		$nombrepub = $rowpub["name"];

		$sqls = "INSERT INTO logs (user, action, timestamp)".
			"VALUES ('$nombreu', 'Denegó la solicitud de $nombrepub', '$horario')";
		$link->query($sqls);

		$sqlup = ("DELETE FROM retros WHERE id = '$id'");
		$link->query($sqlup);

		header("location: ../");
	} else {
		echo "No existe una ID";
	}
} else {
	header("location: ../../");
}
?>