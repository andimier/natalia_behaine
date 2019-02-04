<?php
	require("constants.php");

	$connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
	mysql_set_charset('utf8', $connection);

	if (!$connection) {
		die("La conexion a la base de datos fallo: " . mysql_error());
	}

	$db_select = mysql_select_db("natalic6_natab",$connection);
	if (!$db_select) {
		die("La Seleccion de la base de datos fallo: " . mysql_error());
	}
?>