<?php 
    require_once('required/cnx.php');
    require_once('utils/phpfunctions.php');
    require_once('crud/r-schedule.php');

    $transactionState = 'error';
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
        $payer->name = $product_data['payer-name'];
        $payer->email = $product_data['payer-email'];
        $payer->phone = array(
            "area_code" => "",
            "number" => $product_data['payer-phone']
        );

        // $preference->back_urls = array(
        //     "success" => "http://www.impermanencia.com/successful-purchase.php?slot-id=" . $product_data['slot-id'],
        //     "failure" => "http://www.impermanencia.com/canceled-purchase.php?slot-id=" . $product_data['slot-id'],
        //     "pending" => "http://www.impermanencia.com/pending-purchae.php?slot-id=" . $product_data['slot-id']
        // );

        // $preference->auto_return = "approved";

        $preference->payer = $payer;
        $preference->items = array($item);
        $preference->save();

        return $preference;
    }
    
    // validate the slot. Is it free?
    if ($_POST['make-purchase']) {
        $message = '';
        $slotId = $_POST['slot-id'];
        $slotState = getSelectedSlotState($slotId);
        
        if (isset($slotState)) {
            $slotType = $_POST['slot-type'];

            if ($slotType == 'group') {
                $transactionState = 'free';
                echo 'Esta es una cita grupal y más gente puede reservar';
            }

            if ($slotType == 'single' && $slotState == 'free') {
                echo 'Esta es una cita personalizada, se está reservando la hora';

                // Block slot, update table
                blockSlot($slotId);
                $transactionState = 'reserved';
            }
            
            // Must not block the slot, more people can make the purchase
            // Build reference
            $message = 'redirigiendo a Mercado Pago';
            $preference = getPreference($_POST);
            $canMakePurchase = 'yes';
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


            <?php if (isset($preference) && $canMakePurchase == 'yes'): ?> 
                <p> Can make purchase: <?php echo$canMakePurchase; ?></p>

                <form action="/procesar-pago" method="POST">
                    <script
                        src="https://www.mercadopago.com.co/integrations/v1/web-payment-checkout.js"
                        data-preference-id="<?php echo $preference->id; ?>">
                    </script>
                </form>
            <?php endif; ?>
        </div>
    </body>

</html>
