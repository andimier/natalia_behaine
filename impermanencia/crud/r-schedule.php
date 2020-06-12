<?php
    function phpMethods($method, $param) {
        global $connection;

        if (phpversion() < 6) {
            switch ($method) {
                case 'query':
                    return mysql_query($param, $connection);
                    break;
                case 'error':
                    return mysql_error();
                    break;
                case 'fetch':
                    return mysql_fetch_array($param);
                    break;
                case 'num-rows':
                    return mysql_num_rows($param);
                    break;
                case 'close':
                    return mysql_close($connection);
                    break;
            }
        } 
        else {
            switch ($method) {
                case 'query':
                    return mysqli_query($connection, $param);
                    break;
                case 'error':
                    return mysqli_error($connection);
                    break;
                case 'fetch':
                    return mysqli_fetch_array($param);
                    break;
                case 'num-rows':
                    return mysqli_num_rows($param);
                    break;
                case 'close':
                    return mysqli_close($connection);
                    break;
            }
        }
    }
    
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