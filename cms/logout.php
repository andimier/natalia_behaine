<?php require_once("includes/functions.php"); ?>
<?php
//
	// Cuatro pasos para cerrar una sesion
	//
	// 1. Encontrar la sesion
	session_start();
	//
	// 2. Borrar los valores establecidos
	// esta array vacio los borrará todos a la vez
	$_SESSION = array();
	//
	// 3. Destruir la session cookie
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name(), '', time()-42000, '/');
	}
	//
	// 4. Destruir la sesion
	session_destroy();
	//
	header("Location: login.php?logout=1");
	exit;
?>