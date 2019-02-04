<?php
    require_once("includes/requeridos.php");

    $cadena = "Por favor introduce un texto!";
    $q = "SELECT texto, id FROM img_entradas_textos WHERE texto LIKE '%$cadena%'";
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

    $qa_textos = " UPDATE img_entradas_textos SET texto = '' WHERE texto LIKE '%$cadena%'";
    $ra_textos = mysql_query($qa_textos, $connection);
?>