<?php 
    require_once('crud/r-schedule.php'); 
    
    // validate the slot. Is it free?
    if ($_POST['make-purchase']) {
        $message = '';
        $slotId = $_POST['slot-id'];
        $slotState = getSelectedSlotState($slotId);

        if (isset($slotState) && $slotState == 'free') {
            echo 'Canciona';
            // update table
            blockSlot($slotId);
            $transactionState = 'blocked';
            $message = 'redirigiendo a Mercado Pago';
            
            // can pmake the purchase
            // Build reference
        } else {
            // Alert and redirect to last page
            $transactionState = 'blocked';
        }
    }
?>

<html>
    <head>

    </head>

    <body>
        <div class="transaction-message">
            <?php if ($transactionState == 'blocked'): ?>
                <h2>Lo sentimos. El lugar ya está reservado. Por favor vuelve y selecciona otro horario.</h2>
                <a href="index.php">Volver</a>
            <? endif; ?>
        </div>
    </body>

</html>
