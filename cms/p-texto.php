<?php
	require_once("includes/requeridos.php");

    function getTextsByContentIdAndType($connection, $contenido_id, $type) {
        if ($type == 'descripcion_contenido') {
            $q = "SELECT id FROM textos_contenidos WHERE contenido_id = " . $contenido_id . " AND (tipo = '$type' OR tipo = '') AND idioma = 0 ";
        } else {
            $q = "SELECT id FROM textos_contenidos WHERE contenido_id = " . $contenido_id . " AND tipo = '$type' AND idioma = 0";
        }

        return mysql_query($q, $connection);
    }

    function getTextId($connection, $textRows, $type) {
        /*
            in the case of the description, the content has both content and description texts,
            which are created separately (old implementation), and takes the latter.
        */

        while ($row = mysql_fetch_array($textRows)) {
            $textId[] = $row['id'];
        }

		return $textId[$type == 'descripcion_contenido' ? 1 : 0];
    }

    function createAditionalLanguajesTextEntries($connection, $titulo, $seccion_id, $contenido_id, $last_id, $type) {
        $numberOfLanguajes = 3;

        for ($i = 1; $i < $numberOfLanguajes; $i++) {
            $q  = " INSERT INTO textos_contenidos";
            $q .= " (titulo, seccion_id, contenido_id, texto_id, idioma, indice, tipo) ";
            $q .= " VALUES ";
            $q .= " ('$titulo', $seccion_id, $contenido_id, $last_id, $i, 1, '$type')";

            $r = mysql_query($q, $connection);

            if (mysql_affected_rows() >= 1){
                header("Location: editar-textos.php?texto_id=" . $last_id);
            } else {
                echo mysql_error();
            }
        }
    }

    function createBaseLanguajeTextEntry($connection, $titulo, $seccion_id, $contenido_id, $type) {
        $q = " INSERT INTO textos_contenidos";
        $q .= " (titulo, seccion_id, contenido_id, idioma, indice, tipo) ";
        $q .= " VALUES ";
        $q .= " ('$titulo', $seccion_id, $contenido_id, 0, 1, '$type')";

        $r = mysql_query($q, $connection);

        if (mysql_affected_rows() > 0){
            createAditionalLanguajesTextEntries($connection, $titulo, $seccion_id, $contenido_id, mysql_insert_id(), $type);
        } else {
            echo mysql_error();
        }
    }

	if (intval($_GET['contenido_id']) == 0) {
		//header("Location: inicio.php");
	} else {
		$contenido_id = $_GET['contenido_id'];
		$seccion_id = $_GET['seccion_id'];
		$contenido = $_GET['contenido'];
		$titulo = $_GET['titulo'];

        $type = !isset($_GET['tipo']) ? 'descripcion_contenido' : 'descripcion_tecnica';
        $textRows = getTextsByContentIdAndType($connection, $contenido_id, $type);
        $numberOfTextEntries = ($type == 'descripcion_contenido') ? 2 : 1;
        $hasContentAndDescriptionTexts = (mysql_num_rows($textRows) == $numberOfTextEntries);

        if ($hasContentAndDescriptionTexts) {
            $textId = getTextId($connection, $textRows, $type);

            header("Location: editar-textos.php?texto_id=" . $textId);
        } else {
            createBaseLanguajeTextEntry($connection, $titulo, $seccion_id, $contenido_id, $type);
        }
	}
?>
