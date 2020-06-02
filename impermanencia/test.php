<?php
    if (isset($_GET['t'])) {
        //echo 'respondiendo desde el API: ' . $_GET['t'];
    } else {
        // echo 'error';
    }

 
    if (isset($_POST)) {
        // hacer la consulta del slot
        $body = $_REQUEST;
        $headers = getallheaders();
        require_once('crud/r-schedule.php');

        $id = $_POST['slot-id'];
        $slot_data = getSelectedSlotData($id);
        $data = json_encode($slot_data);

        echo $data;
    }
?>