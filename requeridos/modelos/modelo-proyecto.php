<?php
    require_once('utils/phpfunctions.php');

    define('PROJECT_DESCRIPTION', 'descripcion_contenido');
    define('TECHNICAL_DESCRIPTION', 'descripcion_tecnica');

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
        'Ž' => 'Z', 'z' => 'z', 'Z' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u'
    );

    function getCurrentAlbumId($albumId) {
        return isset($_GET['g']) ? $_GET['g'] : $albumId;
    }

    function getGalleryImages($albumId) {
        global $connection;

        if (isset($albumId) || !empty($albumId)) {
            $q = "SELECT id, titulo, tipo, video_key, video_html, imagen1, imagen3 FROM imagenes_albums WHERE album_id=" . $albumId . " ORDER BY posicion ASC";
            $r = phpMethods('query', $q);

            return $r ? $r : [];
        }
    }

    function traerDatosDeLaImagenPrincipal($contenido_id) {
        global $connection;
        global $album_id;

        $r_imagen_contenido = phpMethods('query',
            "SELECT album_id FROM imagenes_albums WHERE contenido_id = " . $contenido_id
        );

        if ($arr_img = phphMethods('fetch', $r_imagen_contenido)) {
            $album_id = $arr_img['album_id'];
        }
    }

    function getEntryIdFromUrlTitle($title) {
        global $connection;

        $query = phpMethods('fetch',
            phpMethods('query',
                "SELECT id, contenido_id FROM textos_contenidos WHERE titulo LIKE '%$title%'"
            )
        );

        return $query['contenido_id'];
    }

    function getUrlTitle() {
        return str_replace('-', " ", $_GET['p']);
    }

    function getProjectVideoUrl($videoId) {
        return '//player.vimeo.com/video/' . $videoId;
    }

    function getProjectTexts($project_id) {
        global $idioma;
        global $connection;
        $projectDescription = '';
        $tecnicalDescription = '';

        $r_proy_txt = phpMethods('query',
            "SELECT * FROM textos_contenidos WHERE contenido_id=" . $project_id . " AND idioma=" . $idioma . " ORDER BY id ASC"
        );

        if (phpMethods('num-rpws', $r_proy_txt) >= 1) {
            while ($item = mysql_fetch_array($r_proy_txt)) {
                $tipo = $item['tipo'];
                $descriptionTextWithoutHTMLTags = strip_tags($item['contenido']);
                // Strip any HTML tag from the content field to check if it is really empty

                if ((empty($tipo) || $tipo == PROJECT_DESCRIPTION) && !empty($descriptionTextWithoutHTMLTags)) {
                    // if == It is not the text from the content which is created frist.
                    // The content has 3 sets oftexts, the content title, content description and technical description.

                    $projectDescription = $item['contenido'];
                } else if ($tipo == TECHNICAL_DESCRIPTION) {
                    $tecnicalDescription = $item['contenido'];
                }
            }
        }

        return ['descripcion-obra' => $projectDescription, 'descripcion-tecnica' => $tecnicalDescription];
    }
    
    function getVideoSRC($html) {
        preg_match('/https:\/\/[a-zA-Z\.\/=0-9?_]+/', $html, $match);

        return $match[0];
    }

    function getInstallationLinkTagAttributes($output) {
        $att = 'class="f-box" 
            href="'.$output['largeImage'].'" 
            img-id="'.$output['id'].'" 
            title="'.$output['title'].'" 
            type="'. $output['type'].'"';
 
        if ($output['type'] == 'video') {
            return $att . ' video-key="'. $output['videoKey'].'" video-src="'.$output['videoSRC'].'"';    
        }

        return $att;                        
    }

    function getInstallationItems($query) {
        $output = [];

        if (!empty($query)) {
            while ($item = mysql_fetch_array($query)) {
                array_push($output, [
                    'id' => $item['id'],
                    'title' => $item['titulo'],
                    'type' => $item['tipo'],
                    'videoSRC' => !empty($item['video_html']) ? getVideoSRC($item['video_html']) : '',
                    'videoKey' => $item['video_key'],
                    'smallImage' => strpos($item['imagen1'], 'video') ? $item['imagen1'] : "cms/{$item['imagen1']}",
                    'largeImage' => strpos($item['imagen3'], 'video') ? $item['imagen3'] : "cms/{$item['imagen3']}"          
                ]);

                $output[count($output) - 1]['linkTagAttributes'] = getInstallationLinkTagAttributes($output[count($output) - 1]);
            }
        }

        return $output;
    }

    function getProjectQuery() {
        global $connection;

        return phpMethods('fetch',
            phpMethods('query',
                "SELECT * FROM contenidos WHERE id=" . getEntryIdFromUrlTitle(getUrlTitle()),
            )
        );
    }

    function getDataList() {
        global $idioma;
        $dataList = [];

        if ($project = getProjectQuery()) {
            $title_es = getContentTitle($project['id'], 0);
            $title_en = getContentTitle($project['id'], 1);

            $dataList["project_id"] = $project['id'];
            $dataList["project_title"] = getContentTitle($project['id'], $idioma);
            $dataList["project_title_es"] = stripSpecialCharacters($title_es);
            $dataList["project_title_en"] = stripSpecialCharacters($title_en);
            $dataList["project_audio"] = $project['archivo1'];

            if ($project['video']) {
                $dataList["project_video"] = videoSeccion($project['video'], $idioma);
                $dataList["project_video_galery_link"] = videoSeccion($project['galeria_videos'], $idioma);
            }

            $dataList["project_image_small"] = $project['imagen1'];
            $dataList["project_image_large"] = $project['imagen3'];

            $dataList["installation"] = getInstallationItems(
                getGalleryImages(
                    getAlbumId($project['id'])['installation'][0]
                )
            );

            $dataList["project_purchase"] = $project['compra'];

            return $dataList;
        } else {
            echo 'this is not a valid query' . mysql_error();
        }
    }

    function getQueryCondition($i) {
        return ($i == 0) ? " AND visible = 1" : " AND tipo LIKE 'instalacion'";
    }

    function getProjectId() {
        global $projectDataList;

        return isset($projectDataList) ? $projectDataList['project_id'] : $_GET['g'];
    }


    function getAlbumIDS($projectId, $queryCondition) {
        global $connection;

        return phpMethods('query', 
            "SELECT id, titulo FROM albumes WHERE contenido_id=" . $projectId . "{$queryCondition}"
        );
    }

    function getAlbumId($projectId) {
        $typeEntries = ['normal', 'installation'];
        $queryList = [ $typeEntries[0] => [], $typeEntries[1] => [] ];

        for ($i = 0; $i < count($typeEntries); $i++) {
            $item = phpMethods('fetch', 
                getAlbumIDS($projectId, getQueryCondition($i))
            );
   
            array_push(
                $queryList[$typeEntries[$i]], 
                $item != NULL ? $item['id'] : ''
            );
        }

        return $queryList;
    }

    function getExtras() {
        $q_extras  = " SELECT *";
        $q_extras .= " FROM contenidos";
        $q_extras .= " WHERE contenido_id = " . $projectDataList['project_id'];
        $q_extras .= " ORDER BY contenidos.id ASC" ;

        $r_extras = mysql_query($q_extras, $connection);
    }

    function getAllProjectsId() {
        global $connection;

        $r_todoslosproyectos = phpMethods('query',
            'SELECT id, fecha, titulo FROM contenidos WHERE seccion_id = 3 AND contenido_id = 0 ORDER BY fecha'
        );

        while ($losp = phpMethods('fetch', $r_todoslosproyectos)) {
            $proy_arr[] = $losp['id'];
        }

        return $proy_arr;
    }

    function getContentsPreviousOrNextProjectButtonText($key, $proy_arr) {
        global $connection,
            $arrcaract;

        if (!empty($proy_arr[$key])) {
            $response = phpMethods('query', 'SELECT * FROM contenidos WHERE id = ' . $proy_arr[$key], $connection);
            $text = phpMethods('fetch', $response)['titulo'];

            $joined_text = str_replace(' ','-', $text);
            $title = str_replace(array_keys($arrcaract), array_values($arrcaract), $joined_text);

            return strtolower($title);
        }
    }

    function getNextProjectButtonTitle() {
         global $projectDataList,
            $proy_arr;

        $key = array_search($projectDataList['project_id'] , $proy_arr);
        $nextKey = $key + 1;

        return getContentsPreviousOrNextProjectButtonText($nextKey, $proy_arr);
    }

    function getPreviousProjectButtonTitle() {
        global $projectDataList,
            $proy_arr;

        $key = array_search($projectDataList['project_id'] , $proy_arr);
        $previousKey = $key - 1;

        return getContentsPreviousOrNextProjectButtonText($previousKey, $proy_arr);
    }

    function buildUrl($projectTitle) {
        global $idioma,
            $gn_arr;

        $ruta_anterior  = $gn_arr['idiomas'][$idioma]['abrev'];
        $ruta_anterior .= ($idioma != 0) ? '/' : '';
        $ruta_anterior .= strtolower($gn_arr['titulos']['proyecto'][$idioma]).'/';
        $ruta_anterior .= $projectTitle;

        return $ruta_anterior;
    }

    function getNextProjectUrl() {
        $tt_sig = getNextProjectButtonTitle();

        if (!empty($tt_sig)) {
           $url = buildUrl($tt_sig);

           return $url;
        }
    }

    function getPreviousProjectUrl() {
        $tt_prev = getPreviousProjectButtonTitle();

        if (!empty($tt_prev)) {
            return buildUrl($tt_prev);
        }
    }
    
    function getMaxImagesOnDisplay($img_arr) {
        return (count($img_arr) <= 6) ? count($img_arr) : 6;
    }

    function setImagesCountText($idioma, $img_arr, $gn_arr) {
        $photoGaleryText = $gn_arr['titulos']['galeria-de-fotos'][$idioma];
        $numberOfPhotosBinder = $gn_arr['titulos']['de'][$idioma];

        return "{$photoGaleryText}  ".getMaxImagesOnDisplay($img_arr)." {$numberOfPhotosBinder} ". count($img_arr);
    }

	function reemplazarCaracteres($cadena) {
		return str_replace('"','&quot;', $cadena);
	}

    function getAltText($connection, $altTextQuery, $imagenId) {
        $altText = '';

        while ($text = phpMethods('fetch', $altTextQuery)) {
            $altText = $text['img_id'] == $imagenId ? reemplazarCaracteres($text['texto']) : '';
        }

        return $altText;
    }

    function getAltTextsQuery($connection, $idioma, $imagenId) {
        return phpMethods('query',
            "SELECT img_id, texto FROM img_entradas_textos WHERE img_id=" . $imagenId . " AND idioma = " . $idioma
        );
    }

	function traerImagenesYpiesDePagina($r_imagenes) {
		global $r_imagenes,
            $idioma,
            $connection;

		$img_arr = array();
        $i = 0;

		if ($r_imagenes && phpMethods('num-rows', $r_imagenes) >= 1) {
			while ($imagen = phpMethods('fetch', $r_imagenes)) {
                $imagenId = $imagen['id'];

                $img_arr[] = array(
                    $i => $imagenId,
                    "imagen1" => $imagen['imagen1'],
                    "imagen3" => $imagen['imagen3'],
                    "alt" => ""
                );

                $altTextQuery = getAltTextsQuery($connection, $idioma, $imagenId);
                $img_arr[$i]["alt"] = getAltText($connection, $altTextQuery, $imagenId);

                $i++;
			}

            return $img_arr;
		} else {
            return 'something went wrong';
        }
	}

    function getTrackTitle() {
        global $projectDataList;

        $ex = explode('/', $projectDataList['project_audio']);
        $nom1 = end($ex);
        $exp_ext = explode('.', $nom1);
        $nom_cancion = $exp_ext[0];
    }

    function buildInstallationImagesList() {
        if (!empty(getAlbumId()['installation'][0]))

        while ($img = mysql_fetch_array($installationImages)) {
            echo $img['id'] .'<br>';
        }
    }

    if ($seccion == 5) {
        $projectDataList = getDataList();
    }

    $albumId = getAlbumId(getProjectId())['normal'][0];
    $r_imagenes = getGalleryImages(getCurrentAlbumId($albumId));
	$img_arr = traerImagenesYpiesDePagina($r_imagenes);

    if ($seccion == 5) {
        $textos = str_replace("'", "&#39;", getProjectTexts($projectDataList['project_id']));

        $proy_arr = getAllProjectsId();
        $dataList = $projectDataList;
        $videoData = isset($dataList['project_video']) ? $dataList['project_video'] : '';

        $galeria = isset($dataList["project_video_galery_link"]) ? $dataList["project_video_galery_link"] : '';
        $imageId = getImageId($dataList['project_image_small']);
        $largeImage = $dataList['project_image_large'];

        $title_es = $dataList["project_title_es"];
        $title_en = $dataList["project_title_en"];

        // PONER LINEA DE BASE AL VIDEO, CUANDO NO EXISTAN LAS SECCIONES QUE VAN POR DEBAJO
        $estilo = (empty($galeria) || $galeria == 0) ? "1px solid #CCCCCC" : '';
        $topGalleryPadding = (!empty($videoData) || $videoData == 0) ? 'default-top-padding' : '';

        $nom_cancion = getTrackTitle();
        $ruta_siguiente = getNextProjectUrl();
        $ruta_anterior = getPreviousProjectUrl();
    }

?>