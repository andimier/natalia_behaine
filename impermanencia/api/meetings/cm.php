<?php
    require_once('../../required/cnx.php');
    require_once('../../utils/phpfunctions.php');
    require_once('../../crud/r-schedule.php');

    class Token {

        function __construct() {
            $this->redirectUri = "http://www.andimier.com/apitests/meetings/cm.html";
            $this->keyAndSecret = "WUJISVd3SVRUaktudmpRckhjbDlSdzpEbFh3SEJSREdFWW1ucnNDQUVSSjJ3dTlHNEhCbTIyQQ==";
            $this->apiHost = "https://zoom.us/oauth/token";
            $this->localTestUrl = "http://localhost/nataliabehaine/dev-nataliabehaine/impermanencia/api/meetings/cm.php?code=3964982734hbd293bd92";
        }

        private function getCode() {
            return $_GET['code'];
        }

        private function getSlotInfo() {
            if (isset($_GET['state'])) {
                $slotInfo = explode(',', $_GET['state']);
                $slotId = explode(':', $slotInfo[0]);

                // get db info
                return getSelectedSlotData($slotId[1]);
            }

            return null;
        }

        private function getTokenData() {
            $queryParams = [
                "grant_type=authorization_code",
                "code=".$this->getCode(),
                "redirect_uri=" . $this->redirectUri
            ];

            $url = $this->apiHost . "?" . join("&", $queryParams);
    
            try {
                $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL, $url);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                // curl_setopt($ch, CURLOPT_POST, 1); 
                // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $this->keyAndSecret)); 

                // $data = curl_exec($ch);
                // echo $data;

                // curl_close($ch);

                $data = file_get_contents('success-responde-mock.json', true);

                return $data;

            } catch (Exception $e) {
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            }
        }

        public function getData() {
            $data = $this->getTokenData();
            $slotData = $this->getSlotInfo();

            if ($data != NULL) {
                $parsedData = json_decode($data);

                if (isset($parsedData->{'erro'})) {
                    return $parsedData->{'erro'};
                }

                return [
                    $parsedData->{'access_token'},
                    $slotData
                ];
            }

            return NULL;
        }
    }

    if (isset($_GET['code'])) {
        $token = new Token();
        $data = $token->getData();
        $slotInfo = $data[1];
    }
?>

<!DOCTYPE html>
<html>
    <div>
        Creando la reunión en Zoom...
    </div>

    <div id="data-container" data-request-data="<?php echo $data[0]; ?>">
        <ul>
            <li>Meeting slot state: <?php echo $slotInfo['state']; ?></li>
            <li>Meeting type: <?php echo $slotInfo['type']; ?></li>
            <!-- <li>Your name: <?php echo $slotInfo['name']; ?></li>
            <li>Your email: <?php echo $slotInfo['email']; ?></li> -->
        </ul>
    </div>

    <script src="cm.js"></script>
</html>