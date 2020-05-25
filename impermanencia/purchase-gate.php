<?php 
    require_once('crud/r-schedule.php'); 
    
    // validate the slot. Is it free?
    if ($_POST['make-purchase']) {
        $slotId = $_POST['id'];
        $slotState = getSelectedSlot($slotId);

        if (isset($slotState) && $slotState == 'free') {
            
            // update table
            blockSlot($slotId);
            
            // can pmake the purchase
            // Build reference
        } else {
            // redirect to last page
            header('Location: index.php');
        }
    }
?>