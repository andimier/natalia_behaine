<?php 
	function getKeyWords() {
		global $idioma;

		if ($idioma) {
			return [
				1 => $f_metas['palabras1'],
				2 => $f_metas['palabras2'],
				3 => $f_metas['palabras3']
			][$idioma];
		}

		return '';
	}

	function getDescription() {
		global $idioma;
		
		if ($idioma) {
			return [
				1 => $f_metas['descripcion1'],
				2 => $f_metas['descripcion2'],
				3 => $f_metas['descripcion3']
			][$idioma];
		}

		return '';
	} 
?>

<!--<base href="http://www.nataliabehaine.com">-->
<base href="http://localhost/nataliabehaine/dev-nataliabehaine/">
<meta  http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<title><?php echo $gn_arr['tag-titulos'][$seccion][$idioma]; ?> </title>
<link rel="shorcut icon" href="imagenes/icon.png" type="image/x-icon" />
<meta name="viewport" content="width=device-width , initial-scale=1 , user-scalable=no"/>
<meta name="title" content="" />

<meta name="keywords" content="<?php echo getKeyWords(); ?>" />
<meta name="description" content="<?php echo getDescription(); ?>" />
<meta name="author" content="www.andimier.com"/>

<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700|Dorsa' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=IM+Fell+English:400,400italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css"  media="screen" href="fuentes/tarzana/stylesheet.css"  />
<link rel="stylesheet" type="text/css"  media="screen" href="estilos/cabezote-gr.css"  />
<link rel="stylesheet" type="text/css"  media="only screen and (min-width:480px) and (max-width:800px)" href="estilos/cabezote-md.css" />
<link rel="stylesheet" type="text/css"  media="only screen and (min-width:50px) and (max-width:479px)"  href="estilos/cabezote-pq.css" />
<link href="estilos/general-gr.css" rel="stylesheet" type="text/css"  media="screen"   />
<link href="estilos/general-md.css" rel="stylesheet" type="text/css"  media="only screen and (min-width:481px) and (max-width:800px)"  />
<link href="estilos/general-pq.css" rel="stylesheet" type="text/css"  media="only screen and (min-width:50px) and (max-width:480px)"   />

<script src="js/jquery-1.11.3.min.js"></script>
