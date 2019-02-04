<?php
	require_once("includes/requeridos.php");
	require_once("includes/mensaje-reload.php");
	require_once('includes/idiomas-arr.php');

	$msj_nueva_imagen = "";
	$mensaje = "";
	$eliminar = 0;

	if (isset($_GET['album_id'])) {
		$album_id = $_GET['album_id'];
		$titulo = $_GET['album'];

		onRefresh();

		$imagenes = "SELECT * FROM imagenes_albums WHERE album_id = {$album_id} ORDER BY posicion ASC";
		$album = mysql_query($imagenes, $connection);

		$tabla = 'imagenes_albums';
		$campo = 'album_id';
		$campo_id = $album_id;
		$tema = 'tema';
        $isInstallation = isset($_GET['tipo']);
	}
?>