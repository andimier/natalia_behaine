<?php 

require_once("includes/requeridos.php");

$id = 168;

$q_imagen1  = ' DELETE FROM img_entradas_textos WHERE img_id = ' . $id ;
$r_imagen1 = mysql_query($q_imagen1, $connection);


$q_imagen2  = ' DELETE FROM img_entradas WHERE img_id = ' . $id ;
$r_imagen2 = mysql_query($q_imagen2, $connection);


$q_imagen3  = ' DELETE FROM imagenes_albums WHERE id = ' . $id ;
$r_imagen3 = mysql_query($q_imagen3, $connection);

?>	