<?php
	require_once("includes/requeridos.php");

	$mensaje = "";
	$mensaje2 = "";
	$imagen = "";

	function actualizarVideos($videos, $galeria_videos, $connection) {
		global $mensaje;
		$q_video  = " UPDATE contenidos";
		$q_video .= " SET video = '$videos', galeria_videos = '$galeria_videos'";
		$q_video .= " WHERE id = " . $_GET['contenido_id'];

		if (mysql_query($q_video, $connection)) {
			$mensaje = '<div id="mensaje_positivo">El contenido fue actualizada correctamente!</div>';
		} else {
			$mensaje = '<div id="mensaje_negativo">El contenido no fue actualizada. No hiciste ningún cambio.</div>';
			mysql_error();
		}
	}

	if (intval( $_GET['contenido_id'] ) == 0) {
		header("Location: content.php");	
		exit;
	} else {
		require_once('edicion/cambio-archivo.php');	

		if (isset($_POST['bvideo'])) {
			$video1 = (!empty($_POST['video1'])) ? $_POST['video1'] : 0;
			$video2 = (!empty($_POST['video2'])) ? $_POST['video2'] : 0;
			$video3 = (!empty($_POST['video3'])) ? $_POST['video3'] : 0;
			$videos = $video1.",".$video2.",".$video3;

			$galeriaDeVideo1 = (!empty($_POST['galeria_videos1'])) ? $_POST['galeria_videos1'] : 0;
			$galeriaDeVideo2 = (!empty($_POST['galeria_videos2'])) ? $_POST['galeria_videos2'] : 0;
			$galeriaDeVideo3 = (!empty($_POST['galeria_videos3'])) ? $_POST['galeria_videos3'] : 0;
			$galeriasDeVideos = $galeriaDeVideo1.",".$galeriaDeVideo2.",".$galeriaDeVideo3;

			//$galeria_videos = (!empty($_POST['galeria_videos'])) ? $_POST['galeria_videos'] : 0;

			// ACTUALIZACION DE LOS VIDEOS
			actualizarVideos($videos, $galeriasDeVideos, $connection);
		}

		encontrar_seccion_y_contenido_seleccionados();
		require_once("edicion/parametros_actualizacion.php");

		$tituloboton = "Eliminar";
		$archivo_eliminar = 'edicion/eliminar-contenidos.php';
	}
?>
