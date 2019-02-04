<?php
    function traer_album_por_id($album_id){
		global $connection;
		$query = "SELECT * FROM albumes WHERE id =" . $album_id . " LIMIT 1";

		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);

		if ($album = mysql_fetch_array($result_set)) {
			return $album;
		} else {
			return NULL;
		}
	}

    function getParentContent() {
        global $connection;

        $query = "SELECT * FROM contenidos WHERE seccion_id IN (3,4,8) AND contenido_id = 0 ORDER BY seccion_id";

        return mysql_query($query, $connection);
    }

    function getSelectedParent($selectedAlbum) {
        global $connection;

        $selectedParentContent = '';

        $q_content = "SELECT * FROM contenidos WHERE id = " . $selectedAlbum;
        $r_content = mysql_query($q_content, $connection);

        if (mysql_num_rows($r_content) > 0) {
            while ($content = mysql_fetch_array($r_content)) {
                $selectedParentContent = $content['titulo'];
            }
        }

        return $selectedParentContent;
    }

    function getGalleryUrlLink($selectedAlbum) {
        $galleryUrlLink = "editar-galeria.php?album_id=" . $selectedAlbum['id'] . "&album=" . $selectedAlbum['titulo'];

        if (isset($_GET['tipo'])) {
            $galleryUrlLink = $galleryUrlLink . "&tipo=instalacion";
        }

        return $galleryUrlLink;
    }

	if (isset($_GET['album_id'])) {
        require_once("includes/sesion.php");
        require_once("includes/connection.php");
        require_once("includes/functions.php");

        $mensaje = "";
        $mensaje2 = "";
        $imagen = "";

        require_once('edicion/edc_imagenes/img_cambio.php');
        require_once("edicion/actualizaciondecontenidos.php");

		$album_seleccionado = traer_album_por_id($_GET['album_id']);
        $r_contenido = getParentContent();
        $selectedParentContent = '';
        $galleryUrlLink = getGalleryUrlLink($album_seleccionado);

        if ($album_seleccionado['contenido_id'] > 0) {
            $selectedParentContent = getSelectedParent($album_seleccionado['contenido_id']);
        }

        // PARAMETROS ACTUALIZACION Y ELIMINACION DE CONTENIDOS
        require_once("edicion/parametros_actualizacion.php");

        $tituloboton = "Eliminar";
        $archivo_eliminar = 'edicion/eliminar-album.php';
	} else {
		header("Location: inicio.php");
		exit;
	}
?>
