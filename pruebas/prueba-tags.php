<?php
	require_once('../requeridos/conexion/connection.php');

    $q_palabras = "SELECT * FROM metatags WHERE seccion_id = 1";

    if (mysql_query($q_palabras, $connection)) {
        echo "exito";
        $r_palabras = mysql_query($q_palabras, $connection);
    } else {
        echo mysql_error();
    }

    while($pa = mysql_fetch_array($r_palabras)) {
        echo $pa['palabras1'] . '<br />';
    }
    echo 'hola';
?>