<?php

	
	list( $w_orig, $h_orig ) = getimagesize( $ruta3 );
	$scale_ratio = $w_orig / $h_orig;
	
	//Este es el tamaño del que quedarán las imágenes en la carpeta de MEDIANAS. Viene del archivo de edición.
	$w = 460;
	$h = 195;
	
	$w_imgfinal = $w;
	$h_imgfinal = $h;

	if ( ($w/$h) > $scale_ratio ){
		$w = $h * $scale_ratio;
	}else{
		$h = $w / $scale_ratio;
	}

		
	if($extension == "gif"){
		$img = imagecreatefromgif($ruta3);
	}else if($extension == "png"){
		$img = imagecreatefrompng($ruta3);
	}else{
		$img = imagecreatefromjpeg($ruta3);
	}
	
	// Acá se define la posición de la imagen sobre el cuedro negro de fondo.
	$src_x = ($w_imgfinal/2)-($w/2);
	$src_y = ($h_imgfinal/2)-($h/2);

	$basenuevaimagen = imagecreatetruecolor( $w_imgfinal, $h_imgfinal );  //  esta funcion crea un rec negro con los parametros dados
	
	imagecopyresampled( $basenuevaimagen, $img, $src_x, $src_y, 0, 0, $w, $h, $w_orig, $h_orig );
	
	imagejpeg( $basenuevaimagen, $ruta2 )
	
	
	/*if( imagejpeg( $basenuevaimagen, $ruta_destino, 80 ) ){
		
		//no importa que se cree con jpeg, aun asín mantienen su extension original
		/// CROP
		$archivo_origen  = $ruta_destino;
		$destino_crop    = $ruta_pequenas;
		$wthumb = 250;
		$hthumb = 250;
		crop_imagen($archivo_origen, $destino_crop, $wthumb, $hthumb, $ext );
	}*/



?>