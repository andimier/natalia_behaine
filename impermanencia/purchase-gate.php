<?php 
    require_once('crud/r-schedule.php');

    $transactionState = 'error';
    
    // validate the slot. Is it free?
    if ($_POST['make-purchase']) {
        $message = '';
        $slotId = $_POST['slot-id'];
        $slotType = $_POST['slot-type'];
        $slotState = getSelectedSlotState($slotId);

        if (isset($slotState)) {

            if ($slotType == 'group') {
                $transactionState = 'free';
                echo 'Esta es una cita grupal y más gente puede reservar';

                // Must not block the slot, more people can make the purchase
                // Build reference
            }

            if ($slotType == 'single' && $slotState == 'free') {
                echo 'Esta es una cita personalizada, se está bloqueando la hora';

                // Block slot, update table
                blockSlot($slotId);
                $transactionState = 'reserved';
                $message = 'redirigiendo a Mercado Pago';

                // Can make the purchase
                // Build reference
            }
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
            <?php if ($transactionState == 'error'): ?>
                <h2>Lo sentimos. Parece que la página que buscas no existe.</h2>
            <? endif; ?>

            <?php if ($transactionState == 'blocked'): ?>
                <h2>Lo sentimos. El lugar ya está reservado. Por favor vuelve y selecciona otro horario.</h2>
                <a href="index.php">Volver</a>
            <? endif; ?>
        </div>
    </body>

</html>
