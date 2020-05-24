<?php
	function phpConnectMethods($method, $param) {
		global $connection;

		if (phpversion() < 6) {
			switch ($method) {
				case 'select_db':
					return mysql_select_db($param, $connection);
					break;
				case 'set_charset':
					return mysql_set_charset($param, $connection);
					break;
				case 'error':
					return mysql_error();
					break;
			}
		} 
		else {
			switch ($method) {
				case 'select_db':
					return mysqli_select_db($connection, $param);
					break;
				case 'set_charset':
					return mysqli_set_charset($connection, $param);
					break;
				case 'error':
					return mysqli_error($connection);
					break;
			}
		}
	}

	require("const.php");

	if (phpversion() < 6) {
		$connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
	} else {
		$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
	}
	
	phpConnectMethods('set_charset', 'utf8');

	if (!$connection) {
		die("La conexion a la base de datos fallo: " . phpConnectMethods('error', NULL));
	}
	
	$db_select = phpConnectMethods('select_db', DB_NAME);

	if (!$db_select) {
		die("La Seleccion de la base de datos fallo: " . phpConnectMethods('error', NULL));
	}
?>