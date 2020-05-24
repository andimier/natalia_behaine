<?php 
    require_once('crud/r-schedule.php'); 
    
    // validate the slot. Is it free?
    if ($_POST['make-purchase']) {
        $slotState = getSelectedSlot($_POST['id']);

        if (isset($slotState) && $slotState == 'free') {
            // can pmake the purchase
        } else {
            // redirect to last page
        }
    }
?>