<?php
	require_once("includes/sesion.php");
	require_once("includes/connection.php");
	require_once("includes/functions.php");

	$mensaje = "";
	$mensaje2 = "";
	$mensaje_filtro = "";

	date_default_timezone_set('America/Bogota');
	$fecha = date("Y-m-d");

	//// INSERCION NUEVO ALBUM ////
	if(isset($_POST['insertar_album'])){

		$titulo = $_POST['titulo'];
		$borrable = 1;

		$errores = array();
		$required_fields = array('titulo');

		$imagen_provisional1 = "imagenes/pequenas/photo.png";
		$imagen_provisional2 = "imagenes/medianas/photo.png";
		$imagen_provisional3 = "imagenes/grandes/photo.png";

		foreach($required_fields as $fieldname){
			if(!isset($_POST[$fieldname]) || (empty($_POST[$fieldname])  && !is_numeric($_POST[$fieldname]))){
				$errores[] = $fieldname;
			}
		}

		if(empty($errores)){
			//// CREACION DEL CONTENIDO ////
			$query  = " INSERT INTO albumes (fecha, titulo, borrable, imagen1, imagen2, imagen3)" ;
			$query .= " VALUES ( ";
			$query .= " '{$fecha}', '{$titulo}', '{$borrable}', '{$imagen_provisional1}', ";
			$query .= " '{$imagen_provisional2}', '{$imagen_provisional3}' ";
			$query .= " )";

			$result = mysql_query($query, $connection);

			if (mysql_affected_rows() >= 1) {
				$mensaje = "";
				$mensaje2 = "Contenido creado correctamente ";
			} else {
				echo mysql_error();
				echo "No se creo nada";
			}
		} else {
			$mensaje = "";
			$mensaje2 = "Debes ingresar un titulo!!";
		}
	}

	require_once('edicion/edc_imagenes/img_cambio.php');
	encontrar_seccion_y_contenido_seleccionados();

    function getAlbums() {
        global $connection;
        $albumsList = [];

        $query = "SELECT * FROM albumes ORDER BY fecha DESC";
        $result = mysql_query($query, $connection);

        if (mysql_num_rows($result) > 0) {
            while($album = mysql_fetch_array($result)) {
                $list = [
                    'albumId' => $album['id'],
                    'albumCreationDate' => $album['fecha'],
                    'albumTitle' => $album['titulo'],
                    'albumType' => $album['tipo'],
                    'albumParentContentTitle' => $album['contenido_titulo'],
                    'albumUrlLink' => "editar-album.php?album_id=" . $album['id']
                ];

                if (!empty($list['albumType'])) {
                    $list['albumUrlLink'] = $list['albumUrlLink'] . "&tipo=" . $album['tipo'];
                }

                array_push($albumsList, $list);
            }

            return $albumsList;
        } else {
            echo mysql_error();
        }
    }

    //print("<pre>" . print_r(getAlbums(), true) . "</pre>");

    $albums = getAlbums();

	//// PARAMETROS FORMULARIO ACTUALIZACION DE CONTENIDOS ////
	$tabla = "secciones";
	$seccion = $seccion_seleccionada['id'];
	$imagenprincipal = $seccion_seleccionada['imagen1'];
	$img = $seccion_seleccionada['imagen2'];
?>