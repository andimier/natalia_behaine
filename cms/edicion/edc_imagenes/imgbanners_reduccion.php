<?php
function reducir_imagen($ruta_origen, $ruta_destino, $w, $h, $ext, $destino2){
	
	list($w_orig, $h_orig,) = getimagesize($ruta_origen);
	$scale_ratio = $w_orig / $h_orig;

	if (($w/$h) > $scale_ratio){
		$w = $h * $scale_ratio;
	}else{
		$h = $w / $scale_ratio;
	}

	$img = "";

	$ext = strtolower($ext);
	
	if($ext == "gif"){
		$img = imagecreatefromgif($ruta_origen);
	}else if($ext == "png"){
		$img = imagecreatefrompng($ruta_origen);
	}else{
		$img = imagecreatefromjpeg($ruta_origen);
	}

	$basenuevaimagen = imagecreatetruecolor($w, $h);  //  esta funcion crea un rec negro com los parametros dados
	imagecopyresampled($basenuevaimagen, $img, 0,0,0,0, $w, $h, $w_orig, $h_orig);
	
	imagejpeg($basenuevaimagen, $ruta_destino, 80);
	imagejpeg($basenuevaimagen, $destino2, 80);
	
}
		
?>