<?php
    if (isset($_POST)) {
        // hacer la consulta del slot

        if (empty($_POST)) {
            echo 'Error: no slot value';
        } else {
            $body = $_REQUEST;
            $headers = getallheaders();
            require_once('crud/r-schedule.php');
    
            $id = $_POST['slot-id'];
            $slot_data = getSelectedSlotData($id);
            $data = json_encode($slot_data);
    
            echo $data;
        }
    }
?>