<?php
    class ConfirmationMails {
        private const SENDER_EMAIL = "nataliabehaine@gmail.com";
        private const SENDER_EMAIL_SUBJECT = "Nueva compra de sesión";
        private const PAYER_EMAIL_SUBJECT = 'Tu compra hecha en Impermanencia';
        private const SENDER = 'Natalia Behaine | impermanencia';

        private $recipient_email = '';

         private function getHeader($mail) {
            $headers  = "From: <{$mail}>\r\n";
			$headers .= "X-Mailer: PHP/" .phpversion(). "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";

            return $headers;
        }

        private function getBodyDirectedToPayer() {
            $body  = "<html>";
			$body .= "<body>";
			$body .= "<strong>INFO DE CONTACTO DESDE EL SITIO WEB</strong>";
			$body .= "<br />";
			$body .= "<br />";
			$body .= "<strong>Nombre:</strong> $nombre <br />";
			$body .= "<strong>Correo:</strong> $mail ";
			$body .= "<br /><br />";
       		$body .= "<strong>Mensaje:</strong> $mensaje";
			$body .= "</body>";
            $body .= "</html>";

            return $body;
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

        private function getBodyDirectedToSender($payer_info, $slot_data, $isPayer) {
            $body_title = $isPayer == TRUE ? 'Muchas gracias por tu compar' : 'Compra hecha por:';

            $body  = "<html>";
			$body .= "<body>";
			$body .= "<h2>" . $body_title . "</h2>";
            $body .= "<br />";

			$body .= "<div>";
			$body .= "<h3>" . $payer_info['name'] . "</h3>";
			$body .= "<p>" . $payer_info['mail'] . "</p>";
            $body .= "</div>";

			$body .= "<ul>";
			$body .= $this->getSlodInfoText($slot_data);
			$body .= "</ul>";

			$body .= "</body>";
            $body .= "</html>";

            return $body;
        }

        function sendMails() {
            $payer_info = MeetingPater::getPayerData($_GET['payer-id']);
            $slot_data = DataSlot::getSelectedSlotData($_GET['slot-id']);

            // send to Natalia
            mail(
                self::SENDER_EMAIL,
                self::SENDER_EMAIL_SUBJECT,
                $this->getBodyDirectedToPayer($payer_info, $slot_data, FALSE),
                $this->getHeader(self::SENDER)
            );

            // send to payer
            mail(
                $payer_info['email'],
                self::PAYER_EMAIL_SUBJECT,
                $this->getBodyDirectedToPayer($payer_info, $slot_data, TRUE),
                $this->getHeader(self::SENDER)
            );
        }
    }

    if (isset($_GET['slot-id'])) {
        $mail = new ConfirmationMails();
        // $mail->sendMails();
    }
?>

<!doctype html>
<html>
    <head></head>
    <body></body>
</html>

