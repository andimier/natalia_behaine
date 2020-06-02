<?php
    require_once('crud/r-schedule.php');

    $slot_data = '';

    if (isset($_GET['slot-id'])) {
        // hacer la consulta del slot
        $id = $_GET['slot-id'];
        $slot_data = getSelectedSlotData($id);
        $data = json_encode($slot_data);
    }
?>

<html data-slot-info="<?php echo implode(',', $slot_data); ?>">

    <script src="meeting.js"></script>
</html>