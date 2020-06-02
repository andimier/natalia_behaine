<?php
    if (isset($_GET['t'])) {
        echo 'respondiendo desde el API: ' . $_GET['t'];
    } else {
        echo 'error';
    }
?>