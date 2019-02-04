<?php
    $idioma = isset($_GET['lang']) ? $_GET['lang'] : 0;

    function redirectFromFrench() {
        $host = $_SERVER['HTTP_HOST'];
        $requesteUri = $_SERVER['REQUEST_URI'];
        $location = 'http://nataliabehaine.com';

        if ($host == 'localhost') {
            $needle = preg_match('/fr\/?([a-z0-9-]?)+/', $requesteUri, $matches);
            $resultindexes = explode('/', $matches[0]);
            $isElementAfterSlashEmpty = empty($resultindexes[1]) ? 'true' : 'false';

            switch (count($resultindexes)) {
                case 1:
                    $location = './';
                    break;
                case 2:
                    $location = '../';
                    break;
                case 3:
                    $location = '../../';
                    break;
            }
        }

        header('Location: ' . $location);
    }

	function piedefoto ($imagen_id) {
		global $piedefoto;
		global $connection;
		global $filastexto;
        global $idioma;

		$q_piedefoto  = " SELECT texto FROM img_entradas_textos WHERE img_id = ". $imagen_id;
		$q_piedefoto .= " AND idioma = ". $idioma;

		if (mysql_query($q_piedefoto)) {
			$r_piedefoto = mysql_query($q_piedefoto);
			$piedefoto   = mysql_fetch_array($r_piedefoto);
			$filastexto  = mysql_num_rows($r_piedefoto);
		} else {
			$piedefoto = NULL;
		}

		return $piedefoto['texto'];
	}

	function getImageId ($ruta_img) {
		$q_idfoto  = " SELECT * FROM imagenes_albums WHERE imagen1 LIKE '%$ruta_img%'";

		if (mysql_query($q_idfoto)) {
			$r_idfoto = mysql_query($q_idfoto);
			$idfoto = mysql_fetch_array($r_idfoto);
		} else {
			echo mysql_error();
		}

		return $idfoto['id'];
	}

	function videoSeccion($cadenaVideos, $idioma) {
		$listadoVideos = explode(',', $cadenaVideos);

		return $listadoVideos[$idioma];
	}

    function getContentTitle ($id, $idioma) {
        global $connection;

        $q_title  = " SELECT titulo";
        $q_title .= " FROM textos_contenidos";
        $q_title .= " WHERE contenido_id = " . $id;
        $q_title .= " AND idioma = " . $idioma;
        $q_title .= " AND seccion_id = 3";
        $q_title .= " AND (tipo = '' OR tipo LIKE '%descripcion_contenido%')";

        // Older contents have no 'type' field in the data base.

        $r_title = mysql_query($q_title, $connection);

        while ($title = mysql_fetch_array($r_title)) {
            $titles[] = $title['titulo'];
        }

        return count($titles) > 1 ? $titles[1] : $titles[0];
    }

    function stripSpecialCharacters($string) {
        $arrcaract = array(
            '"' => '', 'á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'a' => 'a', 'A' => 'A',
            'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'a' => 'a',
            'A' => 'A', 'a' => 'a', 'A' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE',
            'c' => 'c', 'C' => 'C', 'c' => 'c', 'C' => 'C', 'c' => 'c', 'C' => 'C', 'c' => 'c',
            'C' => 'C', 'ç' => 'c', 'Ç' => 'C', 'd' => 'd', 'D' => 'D', 'd' => 'd', 'Ð' => 'D',
            'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'e' => 'e',
            'E' => 'E', 'ê' => 'e', 'Ê' => 'E', 'e' => 'e', 'E' => 'E', 'ë' => 'e', 'Ë' => 'E',
            'e' => 'e', 'E' => 'E', 'e' => 'e', 'E' => 'E', 'e' => 'e', 'E' => 'E', 'ƒ' => 'f',
            'ƒ' => 'F', 'g' => 'g', 'G' => 'G', 'g' => 'g', 'G' => 'G', 'g' => 'g', 'G' => 'G',
            'g' => 'g', 'G' => 'G', 'h' => 'h', 'H' => 'H', 'h' => 'h', 'H' => 'H', 'í' => 'i',
            'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I',
            'i' => 'i', 'I' => 'I', 'i' => 'i', 'I' => 'I', 'i' => 'i', 'I' => 'I', 'j' => 'j',
            'J' => 'J', 'k' => 'k', 'K' => 'K', 'l' => 'l', 'L' => 'L', 'l' => 'l', 'L' => 'L',
            'l' => 'l', 'L' => 'L', 'l' => 'l', 'L' => 'L', 'n' => 'n', 'N' => 'N', 'n' => 'n',
            'N' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'n' => 'n', 'N' => 'N', 'ó' => 'o', 'Ó' => 'O',
            'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'o' => 'o', 'O' => 'O', 'õ' => 'o',
            'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'o' => 'o', 'O' => 'O', 'o' => 'o', 'O' => 'O',
            'ö' => 'oe', 'Ö' => 'OE', 'r' => 'r', 'R' => 'R', 'r' => 'r', 'R' => 'R', 'r' => 'r',
            'R' => 'R', 's' => 's', 'S' => 'S', 's' => 's', 'S' => 'S', 'š' => 's', 'Š' => 'S',
            's' => 's', 'S' => 'S', 'ß' => 'SS', 't' => 't', 'T' => 'T', 't' => 't', 'T' => 'T',
            't' => 't', 'T' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'u' => 'u',
            'U' => 'U', 'û' => 'u', 'Û' => 'U', 'u' => 'u', 'U' => 'U', 'u' => 'u', 'U' => 'U',
            'u' => 'u', 'U' => 'U', 'u' => 'u', 'U' => 'U', 'u' => 'u', 'U' => 'U', 'u' => 'u',
            'U' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'w' => 'w', 'W' => 'W', 'ý' => 'y', 'Ý' => 'Y',
            'y' => 'y', 'Y' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'z' => 'z', 'Z' => 'Z', 'ž' => 'z',
            'Ž' => 'Z', 'z' => 'z', 'Z' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', ' ' => '-'
		);

        return strtolower(str_replace(array_keys($arrcaract), array_values($arrcaract), $string));
    }

	$laseccion = $seccion + 1;
	$q_metas = "SELECT * FROM metatags WHERE seccion_id = " . $laseccion;
	$r_metas = mysql_query($q_metas, $connection);
	$f_metas = mysql_fetch_array($r_metas);

	$q_inicio1 = "SELECT * FROM secciones WHERE id = 1";

	if (mysql_query($q_inicio1, $connection)) {
		$r_inicio1 = mysql_query($q_inicio1, $connection);

		while($imagen = mysql_fetch_array($r_inicio1)){
			$imgInicio = $imagen['imagen2'];
		}
	} else {
		mysql_error();
	}

	if ($seccion == 0) {
		// INICIO
		$q_inicio2 = "SELECT * FROM contenidos WHERE seccion_id = 1";
		$r_inicio2 = mysql_query($q_inicio2, $connection);

		while($contenido = mysql_fetch_array($r_inicio2)){
			$img2 = $contenido['imagen3'];
		}

		$q_inicio3 = "SELECT * FROM textos_contenidos WHERE seccion_id = 1 AND idioma = $idioma";
		$r_inicio3 = mysql_query($q_inicio3, $connection);

		while($texto = mysql_fetch_array($r_inicio3)){
			$txt = $texto['contenido'];
		}
	}

	if ($seccion == 1) {
		// BIO
		$q_video = "SELECT video FROM secciones WHERE id = " . $seccion;
		$r_video = mysql_query($q_video, $connection);
		$f_video = mysql_fetch_array($r_video);
		$video = $f_video['video'];

		$q_bio  = "SELECT textos_contenidos.titulo, textos_contenidos.contenido ";
		$q_bio .= "FROM contenidos, textos_contenidos ";
		$q_bio .= "WHERE contenidos.seccion_id = 2 ";
		$q_bio .= "AND contenidos.indice = 0 ";
		$q_bio .= "AND contenidos.id = textos_contenidos.contenido_id ";
		$q_bio .= "AND idioma = $idioma ";
		$q_bio .= "ORDER BY contenidos.fecha DESC";

		$r_bio = mysql_query($q_bio, $connection);

		$q_menciones  = "SELECT * FROM textos_contenidos ";
		$q_menciones .= "WHERE contenido_id = 6 ";
		$q_menciones .= "AND idioma = $idioma";
		$r_menciones = mysql_query($q_menciones, $connection);
	}

	if ($seccion == 2) {
		// PROYECTOS / SELECCIONAR SOLO EL AÑO
		$q_anos = 'SELECT fecha FROM contenidos WHERE seccion_id = 3 AND contenido_id = 0';
		$r_anos = mysql_query($q_anos, $connection);

		// BUSQUEDA Y ECHO DE LOS AÑOS
		while($anos = mysql_fetch_array($r_anos)){
			$exp_anos = explode('-', $anos['fecha']);
			$los_anos[] = $exp_anos[0];
		}

		// SI EL AÑO ESTÁ ESPECIFICADO PARA TRAER SOLO PROYECTOS DE ESE AÑO
		if (isset($_GET['Y'])) {
			$ano = $_GET['Y'];
		} else {
			// OBTENER EL AÑO MÁS RECIENTE
			$fecha = max($los_anos);
			$explotarano = explode('-', $fecha);
			$ano = $explotarano[0];
		}

        function getPoyectsList($idioma, $connection) {
            $proyectsList = [];

            $q_projects  = " SELECT id, fecha, imagen1";
            $q_projects .= " FROM contenidos";
            $q_projects .= " WHERE seccion_id = 3";
            $q_projects .= " AND contenido_id = 0";
            $q_projects .= " ORDER BY fecha DESC";

            $r_projects = mysql_query($q_projects, $connection);

            if ($r_projects) {
                while ($project = mysql_fetch_array($r_projects)) {
                    array_push($proyectsList, array(
                            "id" => $project['id'],
                            "fecha" => $project['fecha'],
                            "imagen" => $project['imagen1'],
                            "titulo" => getContentTitle($project['id'], $idioma)
                        )
                    );
                }

                return $proyectsList;
            } else {
                echo 'la busqueda falló:' . mysql_error();
            }
        }
    }

	if ($seccion == 3) {
		// BITACORA

        $q_bitacoras  = "SELECT contenidos.fecha, contenidos.titulo, contenidos.imagen3, textos_contenidos.contenido ";
        $q_bitacoras .= "FROM contenidos, textos_contenidos ";
        $q_bitacoras .= "WHERE contenidos.seccion_id = 4 ";
        $q_bitacoras .= "AND textos_contenidos.contenido_id = contenidos.id ";
        $q_bitacoras .= "AND idioma = ' . $idioma . ' ORDER BY fecha";

        $r_bitacoras = mysql_query($q_bitacoras, $connection);

        $arr_textos = array();
        $arr_imagen = array();
    }

	if ($seccion == 4) {
		// CONTACTO
		$q_contacto =
		'SELECT contenidos.id, textos_contenidos.contenido
		FROM contenidos, textos_contenidos
		WHERE contenidos.seccion_id = 6 AND textos_contenidos.contenido_id = contenidos.id AND textos_contenidos.idioma = ' . $idioma;

		$r_contacto = mysql_query($q_contacto, $connection);
		$f_contacto = mysql_fetch_array($r_contacto);
		$info = $f_contacto['contenido'];
	}

	// REDES
	$q_redes = "SELECT contenido FROM contenidos WHERE seccion_id = 7";
	$r_redes = mysql_query($q_redes, $connection);

	while($red = mysql_fetch_array($r_redes)){
		$redes[] = $red['contenido'];
	}

	if ($seccion == 7) {

		// PROYECTO BITACORA

		$tt = $_GET['b'];
		$btt = str_replace('-', ' ', $tt);
		$q_bitacora ="SELECT * FROM  contenidos WHERE seccion_id = 4 AND titulo LIKE '%$btt%'";

		if ($r_bitacora = mysql_query($q_bitacora, $connection)) {

			$f_bitacora = mysql_fetch_array($r_bitacora);
			$bit_id = $f_bitacora['id'];
			$bit_tt = $f_bitacora['titulo'];
			$bit_fec = $f_bitacora['fecha'];
			$bit_vid = $f_bitacora['video'];
			$bit_img3 = $f_bitacora['imagen3'];

			$qbit_txt = 'SELECT * FROM textos_contenidos WHERE contenido_id = ' . $bit_id . ' AND idioma = '. $idioma;
			$rbit_txt = mysql_query($qbit_txt, $connection);
			$fbit_txt = mysql_fetch_array($rbit_txt);

			$bit_txt = $fbit_txt['contenido'];

			$q_album = 'SELECT * FROM albumes WHERE contenido_id = ' . $bit_id . ' AND visible = 1';
			$r_album = mysql_query($q_album, $connection);
			$f_album = mysql_fetch_array($r_album);

			$album_id = $f_album['id'];

		} else {
			mysql_error();
		}
	}

	if ($seccion == 8){
		$q_comercial = "SELECT * FROM secciones WHERE id = 8";
		$r_comercial = mysql_query($q_comercial, $connection);
		$f_comercial = mysql_fetch_array($r_comercial);
		$banner = $f_comercial['imagen3'];
	}

    if ($idioma == 2) {
        redirectFromFrench();
    }

?>