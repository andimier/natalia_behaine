<?php
	function mensajeDeActualizacion() {
		global $mensaje;

		// VERIFICAR SI SE HIZO LA ACTUALIZACION DEL CONTENIDO
		if (isset($_GET['act'])) {
			if ($_GET['act'] == 1){
				$mensaje = '<div id="mensaje_positivo">La seccion fue actualizada correctamente!</div>';
				$_GET['act'] == 0;
			} else {
				$mensaje = '<div id="mensaje_negativo">La seccion no fue actualizada. No hiciste ningun cambio.</div>';
			}
		}
		return $mensaje;
	}

	function onRefresh() {
		global $mensaje;

		// VERIFICAR REFRESH DE LA PAGINA
		$RequestSignature = $_SERVER['QUERY_STRING'];

		if (isset($_SESSION['LastRequest']) && $_SESSION['LastRequest'] == $RequestSignature){
			//echo 'This is a refresh. <br>';
		} else {
			//echo 'This is a new request. <br>';
			$_SESSION['LastRequest'] = $RequestSignature;
			$mensaje = mensajeDeActualizacion();
		}
	}
?>
