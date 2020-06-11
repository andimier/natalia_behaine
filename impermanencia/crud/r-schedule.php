<?php
    // require_once('required/cnx.php');
    // require_once('utils/phpfunctions.php');

    function getTimeSlots ($productCode) {
        global $connection;
        $hours = [];

        $r = phpMethods('query', "SELECT * FROM time_slots WHERE product_code = " . $productCode . " AND state = 'free'");

        while ($h = phpMethods('fetch', $r)) {
            array_push($hours, [
                'product_code' => $h['product_code'],
                'type' => $h['type'],
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

    function getSelectedSlotData ($id) {
        global $connection;
        $data = [];

        $r = phpMethods('query', "SELECT * FROM time_slots WHERE id = " . $id . " LIMIT 1");

        while ($h = phpMethods('fetch', $r)) {
            $data += ['state' => $h['state']];
            $data += ['type' => $h['type']];
            $data += ['meeting_id' => $h['meeting_id']];
        }

        return $data;
    }

    function blockSlot ($id) {
        global $connection;

        $r = phpMethods('query', "UPDATE time_slots SET state = 'blocked' WHERE id =" . $id);
    }
?>