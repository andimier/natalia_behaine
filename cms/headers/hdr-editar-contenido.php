<?php
    require_once("includes/requeridos.php");

	$mensaje = "";
	$mensaje_img = "";
	$imagen = "";

	$texto_titulo  = 'El titulo que se muestra acá, es una referencia. El título del contenido que aparecera ';
	$texto_titulo .= 'en el Sitio Web se encuentrá al hacer click en el boton "Texto" que esta más abajo. Ahí lo ';
	$texto_titulo .= 'puedes editar en los tres idiomas. <br><br><br>';

	if (intval( $_GET['contenido_id'] ) == 0) {
		header("Location: content.php");
		exit;
	}

	// MOSTRAR MENSAJE DE INSERCION DE CONTENIDO
	if (isset($_GET['act'])) {
		$mensaje = '<div id="mensaje_positivo">Contenido creado correctamente</div>';
		unset($_GET['act']);
	}

	require_once('edicion/insertar_textos.php');
	require_once('edicion/edc_imagenes/img_cambio.php');
	require_once("edicion/actualizaciondecontenidos.php");

	// ACTUALIZACION DEL ALBUM VISIBLE DEL fotografo
	if (isset($_POST['btn_veralbumes'])) {
		$album_id = $_POST['visible'];
		$kontenido_id = $_POST['kontenido_id'];

		$q_visible1 = "UPDATE albumes SET visible = CASE id WHEN {$album_id} THEN 1 END WHERE contenido_id = {$kontenido_id}";
		$r_visible1 = mysql_query($q_visible1, $connection);

		if ($r_visible1) {
			//echo 'SIIIII';
		} else {
			mysql_error();
		}
	}

	// poner luego de la actualizaciondecontenidos para ver los cambios
	encontrar_seccion_y_contenido_seleccionados();

	// PARAMETROS ACTUALIZACION Y ELIMINACION DE CONTENIDOS
	require_once("edicion/parametros_actualizacion.php");

	$tituloboton = "Eliminar";
	$archivo_eliminar = 'edicion/eliminar-contenidos.php';

	// ACTUALIZACION DEL ALBUM VISIBLE DEL CONTENIDO
	$filas ="";

	if ($seccion == 3 || $seccion == 4) {
		$q_albumescontenido = "SELECT * FROM albumes WHERE contenido_id = " . $contenido_seleccionado['id'];
		$r_albumescontenido = phpMethods('query', $q_albumescontenido);

		$filas = (phpMethods('num-rows', $r_albumescontenido) > 0) ? 1 : 0;
	}

	$r_textos = phpMethods(
        'query',
        "SELECT * FROM textos_contenidos WHERE contenido_id =" . $contenido_seleccionado['id'] . " AND idioma = 0"
    );

	$r_sub = phpMethods(
        'query', 
        "SELECT * FROM contenidos WHERE contenido_id =" . $contenido_seleccionado['id']
    );

    function getContentSubContents($contentId) {
        global $connection;
        $q_subContents = "SELECT * FROM contenidos WHERE contenido_id =" . $contentId;
        $r_subContents = mysql_query($q_subContents, $connection);

        while ($subContent = mysql_fetch_array($r_subContents)) {
            $data = [
                'title' => $subContent['titulo'],
                'contentId' => $subContent['id'],
                'linkUrl' => 'editar-subcontenido.php?contenido_id=' . $subContent['id'],
            ];
            $subContents[] =  $data;
        }

        return $subContents;
    }

    function getContentAlbums($contentId) {
        global $connection;
        $albums = [];
        $q_albumes = "SELECT * FROM albumes WHERE contenido_id = " . $contentId;
        $r_albumes = mysql_query($q_albumes, $connection);

        while($album = mysql_fetch_array($r_albumes)) {
            $data = [
                'title' => $album['titulo'],
                'contentId' => $album['id'],
                'linkUrl' => 'editar-album.php?album_id=' . $album['id']
            ];
            array_push($albums, $data);
        }

        return $albums;
    }

    function buildSelectedContentLink($selectedContentData) {
        $link_ptextos = 'p-texto.php?';
        $link_ptextos .= 'seccion_id=' . $selectedContentData['sectionId'];
        $link_ptextos .= '&contenido_id=' . $selectedContentData['contentId'];
        $link_ptextos .= '&sub=0';
        $link_ptextos .= '&contenido=Descripcion de la Obra';
        $link_ptextos .= '&titulo=' . $selectedContentData['contentTitle'];

        return $link_ptextos;
    }

    $selectedContentData = [
        'contentId' => $contenido_seleccionado['id'],
        'sectionId' => $contenido_seleccionado['seccion_id'],
        'contentTitle' => $contenido_seleccionado['titulo']
    ];

    function buidSelectedContentLinksList($selectedContentData) {
        $selectedContentId = $selectedContentData['contentId'];
        $selectedContentSectionId = $selectedContentData['sectionId'];
        $subContents = getContentSubContents($selectedContentId);
        $albums = getContentAlbums($selectedContentId);
        $contentsLinks = [
            array(
                'title' => 'Títlo y Descripción de la Obra',
                'contentId' => $selectedContentId,
                'linkUrl' => buildSelectedContentLink($selectedContentData)
            )
        ];

        foreach ($subContents as &$subContent) {
            array_push($contentsLinks, $subContent);
        }

        // EDIT EXTRAS
        if ($selectedContentSectionId == 3 || $selectedContentSectionId == 4) {
            $extrasArray = [ 'title' => 'Editar Audio / Video', 'contentId' => $selectedContentId];
            array_push($contentsLinks, $extrasArray);
        }

        foreach ($albums as &$album) {
            array_push($contentsLinks, $album);
        }

        return $contentsLinks;
    }

    function getContentTextLinkAndButtonText($seccion) {
        global $contenido_seleccionado,
            $connection;

        if ($seccion == 3) {
            $link  = 'p-texto.php?seccion_id=' . $contenido_seleccionado['seccion_id'];
            $link .= '&contenido_id=' . $contenido_seleccionado['id'];
            $link .= '&sub=0';
            $link .= '&contenido=descripcion-de-la-obra';
			$link .= '&titulo=' . $contenido_seleccionado['titulo'];

            $buttonText = 'Descripción de la Obra';
        } else {
            $q = "SELECT * FROM textos_contenidos WHERE contenido_id =" . $contenido_seleccionado['id'] . " AND idioma = 0";
            $r = mysql_query($q, $connection);

            while ($texto = mysql_fetch_array($r)) {
                $txt[] = $texto['id'];
            }

            $link = 'editar-textos.php?texto_id=' . $txt[0] . '&contenido=Texto';
            $buttonText = 'Texto';
        }

        return [$link, $buttonText];
    }

    function getTechnicalDescriptionLinkAndButtonText() {
        global $contenido_seleccionado,
            $connection;

            $link  = 'p-texto.php?seccion_id=' . $contenido_seleccionado['seccion_id'];
            $link .= '&contenido_id=' . $contenido_seleccionado['id'];
            $link .= '&sub=0';
            $link .= '&contenido=descripcion-tecnica';
			$link .= '&titulo=' . $contenido_seleccionado['titulo'];
            $link .= '&tipo=descripcion_tecnica';

            $buttonText = 'Descripción técnica de la Obra';

        return [$link, $buttonText];
    }

    function getAlbums($contentId) {
        global $connection;
        $INSTALLATION_TYPE = 'instalacion';
        $albumsList = [];
        $albumsList['mainAlbumTitle'] = '';
        $albumsList['mainAlbumId'] = '';
        $albumsList['installationTitle'] = '';
        $albumsList['installationId'] = '';

        $result = phpMethods('query', "SELECT * FROM albumes WHERE contenido_id = " . $contentId);

        while ($album = phpMethods('fetch', $result)) {
            if ($album['tipo'] != $INSTALLATION_TYPE) {
                $albumsList['mainAlbumTitle'] = $album['titulo'];
                $albumsList['mainAlbumId'] = $album['id'];
            } else {
                $albumsList['installationTitle'] = $album['titulo'];
                $albumsList['installationId'] = $album['id'];
            }
        }

        return $albumsList;
    }

    $contentTextLinkAndButtonText = getContentTextLinkAndButtonText($seccion);
    $technicalDescriptionLinkAndButtonText = getTechnicalDescriptionLinkAndButtonText();

    $albums = getAlbums($contenido_seleccionado['id']);
    $mainAlbumId = $albums['mainAlbumId'];
    $mainAlbumTitle = $albums['mainAlbumTitle'];  
    $installationId = $albums['installationId'];
    $installationTitle = $albums['installationTitle'];

    //print("<pre>" . print_r($selectedContentData, true) . "</pre>");
    //print("<pre>" . print_r(buidSelectedContentLinksList($selectedContentData), true) . "</pre>");
    //buidSelectedContentLinksList($contenido_seleccionado['id']);

?>