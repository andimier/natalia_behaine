<?php
	require_once("../../includes/sesion.php");
	require_once("../../includes/connection.php");
	require_once("../../includes/functions.php");

	$_SESSION['LastRequest'] = '';
	
	if(isset($_POST['btn-act-imagen'])){
		$texto = mysql_real_escape_string($_POST['texto']);
		$idioma = $_POST['idioma'];

		$q_actualizar  = " UPDATE img_entradas_textos SET texto = '$texto'";

		$q_actualizar .= " WHERE img_id =" . $_POST['id'] ;
		$q_actualizar .= " AND idioma = " . $idioma;

		$r_actualizar = mysql_query($q_actualizar, $connection);

		if (mysql_affected_rows() == 1 ) {
			header('Location: ../../editar-imagen.php?id='. $_POST['id'] . '&idioma=' . $idioma . '&act=1');
		} else {
			//echo mysql_error();
			header('Location: ../../editar-imagen.php?id='. $_POST['id'] . '&idioma=' . $idioma . '&act=0');
		}
	}
?>
