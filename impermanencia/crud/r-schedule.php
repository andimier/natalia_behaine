<?php
    require_once('required/cnx.php');
    require_once('utils/phpfunctions.php');

    function getTimeSlots () {
        global $connection;
        $hours = [];

        $r = phpMethods('query', "SELECT * FROM time_slots");

        while ($h = phpMethods('fetch', $r)) {
            array_push($hours, [
                'date' => $h['date'],
                'hour' => $h['hour'],
                'state' => $h['state']
            ]);
        }

        return $hours;
    }
?>