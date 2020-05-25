<?php
    require_once('required/cnx.php');
    require_once('utils/phpfunctions.php');

    function getTimeSlots () {
        global $connection;
        $hours = [];

        $r = phpMethods('query', "SELECT * FROM time_slots");

        while ($h = phpMethods('fetch', $r)) {
            array_push($hours, [
                'id' => $h['id'],
                'date' => $h['date'],
                'time' => $h['time'],
                'state' => $h['state']
            ]);
        }

        return $hours;
    }

    function getSelectedSlotState ($id) {
        global $connection;
        $state = '';

        $r = phpMethods('query', "SELECT * FROM time_slots WHERE id = " . $id . " LIMIT 1");

        while ($h = phpMethods('fetch', $r)) {
            $state =  $h['state'];
        }

        return $state;
    }

    function blockSlot ($id) {
        global $connection;

        $r = phpMethods('query', "UPDATE time_slots SET state = 'blocked' WHERE id =" . $id);
    }
?>