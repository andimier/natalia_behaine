<?php
    $isTest = TRUE;
    
    require_once('../../required/cnx.php');
    require_once('../../crud/rw-slot-data.php');

    class Token {

        function __construct() {
            global $isTest;
            // !!! TODO: cambiar por la de natalia
            $this->redirectUri = "http://www.andimier.com/apitests/meetings/cm.html";

            // TEST OPTIONS!!!
            if ($isTest == TRUE) {
                $this->redirectUri = "http://localhost/nataliabehaine/dev-nataliabehaine/impermanencia/api/meetings/request-auth.php";
            }

            // ****

            $this->keyAndSecret = "WUJISVd3SVRUaktudmpRckhjbDlSdzpEbFh3SEJSREdFWW1ucnNDQUVSSjJ3dTlHNEhCbTIyQQ==";
            $this->apiHost = "https://zoom.us/oauth/token";
        }

        private function getCode() {
            return $_GET['code'];
        }

        private function getSlotInfo() {
            if (isset($_GET['state'])) {
                $slotInfo = explode(',', $_GET['state']);
                $slotId = explode(':', $slotInfo[0]);

                // get db info
                return DataSlot::getSelectedSlotData($slotId[1]);
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
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_POST, 1); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $this->keyAndSecret)); 

                $data = curl_exec($ch);

                curl_close($ch);

                // TEST OPTION ***
                // $data = file_get_contents('success-responde-mock.json', true);

                return $data;

            } catch (Exception $e) {
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            }
        }

        public function getData() {
            $data = $this->getTokenData();
            // $slotData = $this->getSlotInfo();

            if ($data != NULL) {
                $parsedData = json_decode($data);

                if (isset($parsedData->{'error'})) {
                    return $parsedData->{'error'};
                }

                return [
                    $parsedData->{'access_token'}
                    // $slotData
                ];
            }

            return NULL;
        }
    }

    class Users {
        function __construct($token) {
            $this->token = $token;
        }

        public function getData() {
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.zoom.us/v2/users/');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $this->token)); 

                $data = curl_exec($ch);

                curl_close($ch);

                return $data;

            } catch (Exception $e) {
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            }
        }

        public function getUsersData() {
            $data = $this->getData();

            if ($data != NULL) {
                $parsedData = json_decode($data);

                if (isset($parsedData->{'error'})) {
                    return $parsedData->{'error'};
                }

                return $parsedData->{'users'}[0];
            }

            return NULL;
        }
    }

    class Meeting {
        function __construct($userId) {
            $this->url = "https://api.zoom.us/v2/users/" . $userId . "/meetings";
        }

        private function getUserData() {

        }

        public function createMeeting() {
            $payerData = [];

            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payerData));
                curl_setopt($ch, CURLOPT_URL, $this->url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_POST, 1); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Authorization: Basic " . $this->keyAndSecret,
                    "Content-Type: application/json"
                )); 

                $data = curl_exec($ch);

                curl_close($ch);

                // TEST OPTION ***
                // $data = file_get_contents('success-responde-mock.json', true);

                return $data;

            } catch (Exception $e) {
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            }
        }
    }

    if (isset($_GET['code'])) {
        $token = new Token();
        $tokenData = $token->getData();

        if (isset($tokenData[0]) && !empty($tokenData[0])) {
            $allUsers = new Users($tokenData[0]);
            $usersData = $allUsers->getUsersData();
            $userId = $usersData->{'id'};
        }

        if (isset($userId) && !empty($userId)) {

            if (isset($_GET['meeting-id'])) {
                // get Zoom meeting
                // insert user in meeting
                // get and show meeting url from DB
            } 
            else {
                // create meeting
                // insert meeting_id in DB -> $_GET[slot-id]
                // insert meeting url in DB

                $meeting = new Meeting($userId);
                $meetingData = $meeting->createMeeting();
            }

            

        }

        // echo 'Usuario -> ' . $usersData;

    }
?>

<!DOCTYPE html>
<html>
    <div>
        Creando la reunión en Zoom...
    </div>

        <ul>
            <!-- <li>Meeting slot state: <?php echo $slotInfo['state']; ?></li>
            <li>Meeting type: <?php echo $slotInfo['type']; ?></li> -->
            <!-- <li>Your name: <?php echo $slotInfo['name']; ?></li>
            <li>Your email: <?php echo $slotInfo['email']; ?></li> -->
        </ul>
    </div>

    <!-- <script src="request-meeting.js"></script> -->
</html>