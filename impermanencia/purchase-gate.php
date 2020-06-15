<?php 
    // *** TEST OPTION
    $isTest = TRUE;

    require_once('required/cnx.php');
    require_once('crud/rw-slot-data.php');

    $transaction_state = 'error';
    $canMakePurchase = 'no';

    function getPreference($product_data) {
        require __DIR__ .  '../../vendor/autoload.php';

        $product = $product_data['product'];
        $price = $product_data['price'];  

        MercadoPago\SDK::setAccessToken('TEST-1846012463543814-052417-fed111bdba6036a2bc5cedce1ee1ebf1-288382892');

        // Crea un objeto de preferencia
        $preference = new MercadoPago\Preference();

        // Crea un ítem en la preferencia
        $item = new MercadoPago\Item();
        $item->title = $product;
        $item->quantity = 1;
        $item->unit_price = $price;

        $payer = new MercadoPago\Payer();
        $payer->name = $product_data['payerName'];
        $payer->email = $product_data['payerEmail'];
        $payer->phone = array(
            "area_code" => "",
            "number" => $product_data['payerPhone']
        );

        $preference->payer = $payer;
        $preference->items = array($item);
        $preference->save();

        return $preference;
    }

   
    // validate the slot. Is it free?
    if (isset($_POST['make-purchase'])) {

        $message = '';
        $redirect_url = '';

        $slotId = $_POST['slot-id'];
        $slotData = DataSlot::getSelectedSlotData($slotId);
         
        if ($slotData['state'] == 'free') {

            $transaction_state = 'free';

            $u = new MeetingPayer($_POST);
            $u->insertPayerForSlot();
            $payerId = $u->getInsertedPayerId();

            if ($slotData['type'] == 'single') {
                // Block slot, update table
                DataSlot::blockSlot($slotId);
                $transaction_state = 'reserved';
                $redirect_url = $u->getRediectUrl($payerId, $slotId, $slotData['meeting_id']);
            }

            if ($slotData['type'] == 'group') {
                $redirect_url = $u->getRediectUrl($payerId, $slotId, $slotData['meeting_id']);
            }

            if ($slotData['type'] == 'event') {
                // ** No zoom
                // ** Esta ya debería tener un id de reunión y urls
                // TODO?: Mostrar la url de la reunión o llevar hasta Zoom para actualizarla?
                // Incluir a las grupales??
                $redirect_url = $u->getRediectUrl($payerId, $slotId, $slotData['meeting_id']);
            }

            if ($slotData['type'] == 'course') {
                // No zoom
                $redirect_url = $u->getNoMeetingReservationRedirectUrl();
            }

            $message = 'Redirigiendo a Mercado Pago';
            $preference = getPreference($_POST);
            $canMakePurchase = 'yes';

            echo 'URL de Redireccionamiento: ' . $redirect_url; 
        } else {
            // Alert and redirect to last page
            $transaction_state = 'blocked';
        }
    }
?>

<html>
    <head>

    </head>

    <body>
        <div class="transaction-message">
            <?php if ($transaction_state == 'error'): ?>
                <h2>Lo sentimos. Parece que la página que buscas no existe.</h2>
            <? endif; ?>

            <?php if ($transaction_state == 'blocked'): ?>
                <h2>Lo sentimos. El lugar ya está reservado. Por favor vuelve y selecciona otro horario.</h2>
                <a href="index.php">Volver</a>
            <? endif; ?>

            <?php if (isset($preference) && $canMakePurchase == 'yes'): ?> 
                <p> Can make purchase: <?php echo$canMakePurchase; ?></p>

                <form action="<?php echo $redirect_url; ?>" method="POST">
                    <script
                        src="https://www.mercadopago.com.co/integrations/v1/web-payment-checkout.js"
                        data-preference-id="<?php echo $preference->id; ?>">
                    </script>
                </form>
            <?php endif; ?>
        </div>
    </body>
</html>
