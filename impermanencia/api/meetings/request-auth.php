<?php
    $isTest = TRUE;
    
    require_once('../../required/cnx.php');
    require_once('../../crud/rw-slot-data.php');

    trait Params {
        private function getParams() {
            $b = explode(',', $_GET['state']);
            $obj = [];

            $i = 0;
            while($i < count($b)) {
                $arr = explode(':', $b[$i]);
                $obj += [$arr[0] => intval($arr[1])]; 

                $i++;
            }

            return $obj;
        }

        public function getPayerId() {
            return $this->getParams()['payer-id'];
        }

        public function getSlotId() {
            return $this->getParams()['slot-id'];
        }

        public function getSlotInfo() {
            $slot_id = $this->getSlotId();

            return DataSlot::getSelectedSlotData($slot_id);
        }
    }

    class Token {
        use Params;

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
                $slot_id = $this->getSlotId();

                // get db info
                return DataSlot::getSelectedSlotData($slot_id);
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
        use Params;

        function __construct($userId, $token) {
            // $this->url = "https://api.zoom.us/v2/users/" . $userId . "/meetings";
            // $this->token = $token;
        }

        public function addRegistrantToMeeting() {
            $payer_id = $this->getPayerId();
            $data = MeetingPayer::getPayerData($payer_id);

            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_POST, 1);

                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Authorization: Bearer " . $this->token,
                    "Content-Type: application/json"
                ));

                $data = curl_exec($ch);

                curl_close($ch);

                // TEST OPTION ***
                // $data = file_get_contents('success-responde-mock.json', true);

                return json_decode($data);

            } catch (Exception $e) {
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            }

        }

        private function getRequestBody() {
            $slot_info = $this->getSlotInfo();

            $data = [];
            
            $start_time = $slot_info['date'] . "T" . $slot_info['time'] . ":00Z";
            $user_email = "nataliabehaine@gmail.com";

            $data += ["topic" => "Sesión virtual Natalia Behaine"];
            $data += ["type" => 2];
            $data += ["start_time" => $start_time];
            $data += ["duration" => $slot_info['duration']];
            $data += ["schedule_for" => $user_email];
            $data += ["timezone" => "America/Bogota"];

            $data += ["setings" => [
                "registrants_email_notification" => true
            ]];

            return $data;
        }

        public function createMeeting() {
            $payerData = $this->getRequestBody();
            $body = json_encode($payerData);
            
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_POST, 1);

                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Authorization: Bearer " . $this->token,
                    "Content-Type: application/json"
                ));

                $data = curl_exec($ch);

                curl_close($ch);

                // TEST OPTION ***
                // $data = file_get_contents('success-responde-mock.json', true);

                return json_decode($data);

            } catch (Exception $e) {
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            }
        }

        public function insertMeetingIdInSlot($meetingData) {
            $meeting_id = $meetingData->{'id'};
            $join_url = $meetingData->{'join_url'};
            $start_url = $meetingData->{'start_url'};

            $slot_id = $this->getSlotId();

            DataSlot::updateMeetingId($slot_id, $meeting_id, $start_url, $join_url);
        }
    }

    // *** PRUEBAS
    // $meeting = new Meeting('HJNW9FBN92FNBI2', 'JBSQDIJKQIWDBWQIB');
    // $meetingData = $meeting->createMeeting();

    if (isset($_GET['code'])) {
        $api_token = new Token();
        $token_data = $api_token->getData();
        $token = $token_data[0];

        if (isset($token) && !empty($token)) {
            $allUsers = new Users($token);
            $usersData = $allUsers->getUsersData();
            $userId = $usersData->{'id'};
        }

        if (isset($userId) && !empty($userId)) {

            if (isset($_GET['meeting-id'])) {
                // get Zoom meeting
                // insert user in meeting
                // get and show meeting url from DB

                echo 'INSERTANDO PAGADOR EN REUNIÓN';
            } 
            else {
                echo 'CREANDO REUNIÓN';

                $meeting = new Meeting($userId, $token);
                $data = $meeting->createMeeting();

                if (isset($data) && !empty($data) && !isset($data->{'code'})) {
                    print_r($data);
                    $meeting->insertMeetingIdInSlot($data);
                } else {
                    echo "ERROR!!!";
                }
            }
        }
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