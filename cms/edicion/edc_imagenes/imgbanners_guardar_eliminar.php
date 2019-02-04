<?php
	require_once("../../includes/sesion.php");
	require_once("../../includes/connection.php");
	require_once("../../includes/functions.php");

	function volverAlaGaleria($album_id, $album, $act) {
		header("Location: ../../editar-galeria.php?album_id=" . $album_id . "&album=" . $album . "&act=" . $act);
	}

	function compararArrays($array1, $array2) {
		$cambio = array_diff($array1, $array2);
		return $cambio;
	}

	function actualizarPosicion ($album_id, $album, $posicion, $post_id) {
		global $connection;
		global $act;
		$cambio = 0;
		$array1 = Array();
		$array2 = $posicion;

		$q_pos_actiales = "SELECT posicion FROM imagenes_albums WHERE album_id = " . $album_id . " ORDER BY posicion ASC";
		$r_pos_actuales = mysql_query($q_pos_actiales, $connection);

		while ($pos = mysql_fetch_array($r_pos_actuales)) {
			$array1[] = $pos['posicion'];
		}

		for ($i=0; $i < count($posicion); $i++) {
			$query  = "UPDATE imagenes_albums ";
			$query .= "SET posicion = " . $posicion[$i] . " ";
			$query .= "WHERE id = ". $post_id[$i];

			if ($array1[$i] !== $array2[$i]) {
				$cambio += 1;
			}

			$resultado = mysql_query($query, $connection);
			if ($i === count($posicion)-1){
				if ($cambio >= 1) {
					$act = 1;
				} else {
					$act = 0;
				}

				volverAlaGaleria($album_id, $album, $act);
			}
		}
	}

    function getImagesEntries($i) {
        global $connection;

        return mysql_fetch_array(
            mysql_query(
                "SELECT * FROM imagenes_albums WHERE id=" . $_POST['eliminar'][$i],
                $connection
            )
        );
    }

    function deleteImagesEntriesFromAlbums($i) {
        global $connection;

        mysql_query(
            "DELETE FROM imagenes_albums WHERE id = " . $_POST['eliminar'][$i],
            $connection
        );

        if (mysql_affected_rows() != 1){
            echo 'error, no se aborrado nada ' . mysql_error();
        }
    }

    function deleteImagesFiles($i) {
        $imagen = getImagesEntries($i);
        $route = "../../";

        if (file_exists($route.$imagen['imagen1'])) {
            if (unlink($route.$imagen['imagen1'])) {
                unlink($route.$imagen['imagen2']);
                unlink($route.$imagen['imagen3']);
            }
        }
    }

    function hasTextEntries($i) {
        global $connection;

        $r = mysql_query(
            "SELECT id FROM img_entradas WHERE img_id = " . $_POST['eliminar'][$i],
            $connection
        );

        return mysql_num_rows($r) > 0 ? true : false;
    }

    function deleteImageFromImageTextEntries($i) {
        global $connection;

        mysql_query(
            "DELETE FROM img_entradas WHERE img_id = " . $_POST['eliminar'][$i],
            $connection
        );

    }

    function deleteImageCaptionTextEntries($index) {
        global $connection;

        for ($i = 0; $i < count($idiomas_arr); $i++) {
            mysql_query(
                "DELETE FROM img_entradas_textos WHERE img_id = " . $_POST['eliminar'][$index],
                $connection
            );
        }
    }

    function deleteImagesEntries() {
        for($i = 0; $i < count($_POST['eliminar']); $i++){
            deleteImagesFiles($i);
            deleteImagesEntriesFromAlbums($i);

            if (hasTextEntries($i)) {
                deleteImageFromImageTextEntries($i);
                deleteImageCaptionTextEntries($i);
            }
        }
    }

	if (isset($_POST['btn_guardar'])) {
		$album_id = $_POST['album_id'];
		$album = $_POST['album'];

		if (isset($_POST['posicion'])) {
			$posicion = $_POST['posicion'];
		}

		if (isset($_POST['eliminar']) && !empty($_POST['eliminar'])) {
            deleteImagesEntries();
		}
        
        actualizarPosicion($album_id, $album, $_POST['posicion'], $_POST['id']);
	}

  ?>
