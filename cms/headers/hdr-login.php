<?php 
	if (!isset($_SESSION)) {
		session_start();
	} 

	$mensaje = "";
	$mensaje1 = "";
	$mensaje2 = "";
	$mensaje3 = "";
	$mensaje4 = "";

	require_once("includes/connection.php");
	require_once("includes/functions.php");

	if (isset($_POST['submit'])) {
		$errores = array();
		$required_fields = array('usuario','contrasena');
		//$errores = array_merge($errores, $required_fields);
		//$errores = array_merge($errores, check_required_fields($required_fields, $_POST));
		foreach($required_fields as $fieldname){
			if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname])  && !is_numeric($_POST[$fieldname]))) {
				$errores[] = $fieldname;	
			}
		}

		$username = trim(mysql_prep($_POST['usuario']));	
		$password = trim(mysql_prep($_POST['contrasena']));	
		//algoritmos de incriptacion
		//$hashed_password = md5($password);
		//$hashed_password = hash($password);
		$hashed_password = sha1($password);

		if (empty($errores)) {
			$query = "SELECT id, username FROM usuarios WHERE username = '{$username}' AND hashed_password = '{$hashed_password}'";
			$result = mysql_query($query, $connection);
			confirm_query($result);
			//
			if (mysql_num_rows($result) == 1) {
				$usuario_encontrado = mysql_fetch_array($result);
				$_SESSION['user_id'] = $usuario_encontrado['id'];
				$_SESSION['username'] = $usuario_encontrado['username'];
				header("Location: inicio.php");
				exit;
			} else {
				$mensaje1 = "El nombre de usuario o contraseña pueden estar errados.";
			}

		} else {
			$mensaje2 = "Por favor ingresa los siguientes campos:  ";
			foreach($errores as $error) {
				$mensaje3 = $error . "<br/>";
			} 
			if (count($errores) ==1) {
				$mensaje4 = "Hubo un error en el formulario.<br /><br />";
			} else {
				$mensaje4 = "Hubo " . count($errores) . " errores en el formulario!!<br /><br />" ;
			}
		}
	} else {
		if (isset($_GET['logout']) && $_GET['logout'] == 1) {
			$mensaje = "Has cerrado tu sesión. "	;
		}
		$username = "";	
		$password = "";	
	}

	require_once("includes/functions.php");
?>