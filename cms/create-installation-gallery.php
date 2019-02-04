<?php
    function isValidUrl($contentId) {
        return true;
    }

    function checkRequiredFields() {
        foreach($required_fields as $fieldname){
			if(!isset($_POST[$fieldname]) || (empty($_POST[$fieldname])  && !is_numeric($_POST[$fieldname]))){
				$errores[] = $fieldname;
			}
		}
    }

    function createInstallationGallery($contentId, $contentTitle) {
        global $connection;
        
        $IMAGE_ASSET_SMALL = 'imagenes/pequenas/photo.png';
        $IMAGE_ASSET_MEDIUM = 'imagenes/medianas/photo.png';
        $IMAGE_ASSET_LARGE = 'imagenes/grandes/photo.png';
        
        date_default_timezone_set('America/Bogota');
        $insertionDate = date("Y/m/d - h:i:s");

        // CREACION DEL CONTENIDO
        $query = "INSERT INTO albumes (
            seccion_id,
            contenido_id,
            contenido_titulo,
            fecha,
            titulo,
            borrable,
            imagen1,
            imagen2,
            imagen3,
            tipo
        )" ;
        $query .= " VALUES (
            3,
            '{$contentId}',
            '{$contentTitle}',
            '{$insertionDate}',
            '{$contentTitle}',
            1,
            '{$IMAGE_ASSET_SMALL}', 
            '{$IMAGE_ASSET_LARGE}', 
            '{$IMAGE_ASSET_MEDIUM}',
            'instalacion'
        )";

        mysql_query($query, $connection);

        if (mysql_affected_rows() >= 1) {
            //echo "Contenido creado correctamente ";
            header("Location: ../editar-album.php?album_id=" . mysql_insert_id());
        } else {
            echo mysql_error();
            echo "No se creo nada";
        }
    }

    if (isset($_GET['contentId']) && isValidUrl($_GET['contentId']) == true)  {
        require_once("../includes/sesion.php");
        require_once("../includes/connection.php");


        createInstallationGallery($_GET['contentId'], $_GET['contentTitle']);
    }
?>
