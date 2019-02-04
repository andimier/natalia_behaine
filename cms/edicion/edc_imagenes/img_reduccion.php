<?php
function reducir_imagen( $ruta3, $ruta2, $extension, $ruta1 ){
	
	list( $w_orig, $h_orig ) = getimagesize( $ruta3 );
	$scale_ratio = $w_orig / $h_orig;
	
	// Este es el tamaño del que quedarán las imágenes en la carpeta de MEDIANAS. 
	// Viene del archivo de edición.
		
	$w = 500;
	$h = 500 / $scale_ratio;

	
	if($extension == "gif"){
		$img = imagecreatefromgif($ruta3);
	}else if($extension == "png"){
		$img = imagecreatefrompng($ruta3);
	}else{
		$img = imagecreatefromjpeg($ruta3);
	}
	


	$basenuevaimagen = imagecreatetruecolor($w, $h);  //  esta funcion crea un rec negro con los parametros dados
	imagealphablending($basenuevaimagen, false);
	imagesavealpha($basenuevaimagen, true);

    $trans_colour = imagecolorallocatealpha($basenuevaimagen, 0, 0, 0, 127);
    imagefill($basenuevaimagen, 0, 0, $trans_colour);
	
	
	//imagecopyresampled( $basenuevaimagen, $img, $src_x,$src_y, 0, 0, $w, $h, $w_orig, $h_orig );
	imagecopyresampled( $basenuevaimagen, $img, 0,0, 0, 0, $w, $h, $w_orig, $h_orig );
	
	
	if($extension == "gif"){
		imagegif($basenuevaimagen, $ruta2);
	}else if($extension == "png"){
		imagepng($basenuevaimagen, $ruta2, 9);
	}else{
		imagejpeg($basenuevaimagen, $ruta2, 100);
	}
	
	
	
	/// CROP

	crop_imagen( $ruta3, $ruta1, $extension );
	
}


/////CROP 1

function crop_imagen( $ruta2, $ruta1, $extension ){
	
	list($w_orig, $h_orig) = getimagesize( $ruta2 );
	
	if($w_orig > $h_orig ){
		
		$valor = $h_orig;
		$x_ini = ($w_orig/2) - ($h_orig/2);
		$y_ini = 0;
		
	}else if($h_orig > $w_orig){
		
		$valor = $w_orig;
		$x_ini = 0;
		$y_ini = ($h_orig/2) - ($w_orig/2);
	
	}else{
		
		$valor = $w_orig;
		$x_ini = 0;
		$y_ini = 0;
	}
	
	if($extension == "gif"){
		$img = imagecreatefromgif($ruta2);
	}else if($extension == "png"){
		$img = imagecreatefrompng($ruta2);
	}else{
		$img = imagecreatefromjpeg($ruta2);
	}
	
	$basenuevaimagenpequena1 = imagecreatetruecolor(500, 500);
	imagealphablending($basenuevaimagenpequena1, false);
	imagesavealpha($basenuevaimagenpequena1, true);
	imagecopyresampled($basenuevaimagenpequena1, $img, 0, 0, $x_ini, $y_ini, 500, 500, $valor, $valor);

	
	if($extension == "gif"){
		imagegif($basenuevaimagenpequena1, $ruta1, 100);
	}else if($extension == "png"){
		imagepng($basenuevaimagenpequena1, $ruta1, 9);
	}else{
		imagejpeg($basenuevaimagenpequena1, $ruta1, 100);
	}
	
	

	
}



?>