<?php
    require_once("includes/requeridos.php");

    $cadena = "DescripciÃ³n";
    $q = "SELECT tipo_contenido FROM img_entradas WHERE texto_contenido LIKE '%$cadena%'";
    $r = mysql_query($q, $connection);

    if (mysql_query($q, $connection)) {
        //echo count(mysql_fetch_array($r));
    } else {
        //echo mysql_error();
    }

    $i = 1;
    while ($texto = mysql_fetch_array($r)) {
        echo $i . " - id = " . $texto['id'] . " - " . $texto['texto'] . '<br>';
        $i++;
    }

    $qa_textos = " UPDATE img_entradas SET tipo_contenido = 'Descripción' WHERE tipo_contenido LIKE '%$cadena%'";
    $ra_textos = mysql_query($qa_textos, $connection);
?>