<?php
    /*
    GALERIA
    TRAER LAS IMÁGENES Y LOS TEXTOS DE LOS ALT POR SEPARADO
    METERLOS EN UN ARRAY, LUEGO METERLE EL ALT A ESE ARRAY
    PARA QUE EL QUERY FUNCIONE Y TRAIGA TODAS LA IMÁGENES 
    AUNQUE NO TENGAN ALT.

    $_GET ? GALERÍA : PROYECTO
    */

    $albumId = !isset($album_id) ? $_GET['g'] : $album_id;

    $q_imagenes  = " SELECT ";
    $q_imagenes .= " id, imagen1, imagen3 ";
    $q_imagenes .= " FROM imagenes_albums ";
    $q_imagenes .= " WHERE album_id = " . $albumId; 
    $q_imagenes .= " ORDER BY posicion ASC";
    $r_imagenes = mysql_query($q_imagenes, $connection);
?>