<?php
    require_once('required/cnx.php');
    require_once('utils/phpfunctions.php');

    function getContentTitle () {
        global $connection;

        $r = phpMethods('query', "SELECT * FROM time_slots");

        while ($h = phpMethods('fetch', $r)) {
            $hours[] = $h['date'];
            $hours[] = $h['hour'];
            $hours[] = $h['state'];
        }

        return $hours;
    }
?>