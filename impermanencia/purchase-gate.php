<?php
    // *** TEST OPTION
    $isTest = TRUE;

    require_once('required/cnx.php');
    require_once('crud/rw-slot-data.php');

    $transaction_state = 'error';
    $canMakePurchase = 'no';

    class Purchase {
        function __construct ($post) {
            $this->purchase_data = $post;
            $this->slot_id = $post['slot-id'];
            $this->redirect_url = '';
        }

        private function setPayerId() {
            $payer = new MeetingPayer($this->purchase_data);
            $payer->insertPayerForSlot();
            $payer_id = $payer->getInsertedPayerId();

            $this->payer = $payer;
            $this->payer_id = $payer_id;
        }

        private function setSlotData() {
            $slot_data = DataSlot::getSelectedSlotData($this->slot_id);

            $this->canZoomMakeMeeting = $slot_data['type'] != 'course' || $slot_data['type'] != 'event';
            $this->slot_data = $slot_data;
        }

        private function setPreference() {
            $purchase_data = $this->purchase_data;

            require __DIR__ .  '../../vendor/autoload.php';

            $product = $purchase_data['product'];
            $price = $purchase_data['price'];

            MercadoPago\SDK::setAccessToken('TEST-1846012463543814-052417-fed111bdba6036a2bc5cedce1ee1ebf1-288382892');

            // Crea un objeto de preferencia
            $preference = new MercadoPago\Preference();

            // Crea un ítem en la preferencia
            $item = new MercadoPago\Item();
            $item->title = $product;
            $item->quantity = 1;
            $item->unit_price = $price;

            $payer = new MercadoPago\Payer();
            $payer->name = $purchase_data['payerName'];
            $payer->email = $purchase_data['payerEmail'];
            $payer->phone = array(
                "area_code" => "",
                "number" => $purchase_data['payerPhone']
            );

            $preference->payer = $payer;
            $preference->items = array($item);
            $preference->save();

            $this->preference = $preference;
        }

        private function blockSlot() {
            DataSlot::blockSlot($this->slot_id); // Block slot, update table
        }

        private function setRedirectUrl() {
            $payer = $this->payer;

            if ($this->canZoomMakeMeeting && !isset($this->slot_data['meeting_id'])) {
                // Crear reunión en Zoom
                $this->redirect_url = $payer->getRediectUrl(
                    $this->payer_id,
                    $this->slot_id,
                    $this->slot_data['meeting_id']);
            } else {
                $this->redirect_url = $payer->getNoMeetingReservationRedirectUrl(
                    $this->payer_id,
                    $this->slot_id
                );
            }
        }

        public function getPurchasePreference() {
            return $this->preference;
        }

        public function getRedirectUrl() {
            return $this->redirect_url;
        }

        public function initPurchase() {
            global $transaction_state;

            $this->setPayerId();
            $this->setSlotData();

            $transaction_state = 'free';

            if ($this->slot_data['type'] == 'single' && $this->slot_data['state'] == 'free') {
                $this->blockSlot();
                $transaction_state = 'reserved';
            }

            $this->setPreference();
            $this->setRedirectUrl();
        }
    }

    if (isset($_POST['make-purchase'])) {

        $message = '';

        $purchase = new Purchase($_POST);
        $purchase->initPurchase();
        $preference = $purchase->getPurchasePreference();
        $redirect_url = $purchase->getRedirectUrl();

        $message = 'Redirigiendo a Mercado Pago';
        $canMakePurchase = 'yes';

        echo 'URL de Redireccionamiento: ' . $redirect_url;
    }
?>

<html>
    <head>
    <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css2?family=Arsenal&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Palanquin:wght@100;&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css">
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
