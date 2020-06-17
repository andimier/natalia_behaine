<?php
    class ConfirmationMails {
        private const SENDER_EMAIL = "nataliabehaine@gmail.com";
        private const SENDER_EMAIL_SUBJECT = "Nueva compra de sesión";
        private const PAYER_EMAIL_SUBJECT = 'Tu compra hecha en Impermanencia';
        private const SENDER = 'Natalia Behaine | impermanencia';

        private $recipient_email = '';

        function __construct($payer_info, $slot_data) {
            $this->payer_info = $payer_info;
            $this->slot_data = $slot_data;
        }

         private function getHeader($mail) {
            $headers  = "From: <{$mail}>\r\n";
			$headers .= "X-Mailer: PHP/" .phpversion(). "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";

            return $headers;
        }

        private function getSlodInfoText($slot_data) {
            $time_slot_data = "<li>Esta es la información de la sesión";
            $time_slot_data .= "<li>Duración: " . $slot_data['duration'] . "</li>";
            $time_slot_data .= "<li>Tipo: " . $slot_data['type'] . "</li>";
            $time_slot_data .= "<li>Fecha: " . $slot_data['date'] ."</li>";
            $time_slot_data .= "<li>Hora: " . $slot_data['time'] . "</li>";
            $time_slot_data .= "<li>URL: " . $slot_data['meeting_join_url'] . "</li>";

            return $time_slot_data;
        }

        private function getBody($isPayer) {
            $body_title = $isPayer == TRUE ? 'Muchas gracias por tu compar' : 'Compra hecha por:';

            $body  = "<html>";
			$body .= "<body>";
			$body .= "<h2>" . $body_title . "</h2>";
            $body .= "<br />";

			$body .= "<div>";
			$body .= "<h3>" . $this->payer_info['name'] . "</h3>";
			$body .= "<p>" . $this->payer_info['mail'] . "</p>";
            $body .= "</div>";

			$body .= "<ul>";
			$body .= $this->getSlodInfoText($this->slot_data);
			$body .= "</ul>";

			$body .= "</body>";
            $body .= "</html>";

            return $body;
        }

        function sendMails() {

            // send to Natalia
            // mail(
            //     self::SENDER_EMAIL,
            //     self::SENDER_EMAIL_SUBJECT,
            //     $this->getBodyDirectedToPayer(FALSE),
            //     $this->getHeader(self::SENDER)
            // );

            // // send to payer
            // mail(
            //     $payer_info['email'],
            //     self::PAYER_EMAIL_SUBJECT,
            //     $this->getBody(TRUE),
            //     $this->getHeader(self::SENDER)
            // );
        }
    }

    if (isset($_GET['slot-id'])) {
        $payer_info = MeetingPayer::getPayerData($_GET['payer-id']);
        $slot_data = DataSlot::getSelectedSlotData($_GET['slot-id']);

        $mail = new ConfirmationMails($payer_info, $slot_data);
        $mail->sendMails();
    }
?>

<!doctype html>
<html>
    <head>
    <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css2?family=Arsenal&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Palanquin:wght@100;&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css">
    </head>

    <body>
        <main>
            <header>
                <h1>impermanencia</h1>
                <h4>Natalia Behaine</h4>

                <section id="description">
                    <h2>Resumen de compra</h2>
                </section>
            </header>

            <section>
                <h3>Muchas gracias por tu compra.</h3>
                <p>Este es el resumen de tu compra:</p>
                <p>Tambien hemos enviado un correo con los detalles</p>
            </section>

            <section id="summary">
                <h4>Tus datos:</h4>
                <ul>
                    <li><?php echo $payer_info['name']; ?></li>
                    <li><?php echo $payer_info['email']; ?></li>
                    <li><?php echo $payer_info['phone']; ?></li>
                    <li><?php echo $payer_info['details']; ?></li>
                </ul>

                <h4>Datos de la reunión:</h4>
                <ul>
                    <li><?php echo $slot_data['type']; ?></li>
                    <li><?php echo $slot_data['date']; ?></li>
                    <li><?php echo $slot_data['time']; ?></li>
                    <li><?php echo $slot_data['duration']; ?></li>
                    <li><?php echo $slot_data['meeting_join_url']; ?></li>
                </ul>
            </section>
        </main>

        <footer>

        </footer>
    </body>
</html>

