<?php



	$img = 'darth.jpg';

	$nombreA = "../imagenes/pequenas/" . $img;
	
	$nombreB = "../imagenes/medianas/" . $img;
	$nombreC = "../imagenes/grandes/"  . $img;

	unlink($nombreA);
	unlink($nombreB);
	
	if(unlink($nombreC)){
		echo 'completo';
	}else{
		echo mysql_error();
	}
	
?>