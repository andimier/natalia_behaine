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

        public function getMeetingId() {
            $params = $this->getParams();

            if (isset($params['meeting-id'])){
                return $params['meeting-id'];
            }

            return null;
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

        public function getSelectedUserData() {
            $data = $this->getData();

            if ($data != NULL) {
                $parsedData = json_decode($data);

                if (isset($parsedData->{'error'})) {
                    echo $parsedData->{'error'};
                    return null;
                }

                if (isset($parsedData->{'message'})) {
                    echo $parsedData->{'error'};
                    return null;
                }

                return $parsedData->{'users'}[0];
            }

            return NULL;
        }
    }

    class Meeting {
        use Params;

        private const SUCCESS_OUTPUT_MESSAGE =  'REUNION CREADA CORRECTAMENTE';
        private const CREATING_ZOOM_MEETING = 'CREANDO REUNIÓN';
        private const UPDATING_ZOOM_MEETING = 'INSERTANDO PAGADOR EN REUNIÓN';
        private const ERROR_MESSAGE = 'HA OCURRIDO UN ERROR';

        private $message = '';
        private $meeting_data = NULL;

        function __construct($userId, $userEmail, $token) {
            $this->url = "https://api.zoom.us/v2/users/" . $userId . "/meetings";
            $this->userEmail = $userEmail;
            $this->token = $token;
        }

        private function getRequestBody() {
            $slot_info = $this->getSlotInfo();

            $start_time = $slot_info['date'] . "T" . $slot_info['time'] . ":00Z";
            $user_email = $this->userEmail;

            $data = (object)array(
                "topic" => "Sesion virtual taller con Natalia Behaine",
                "type" => 2,
                "start_time" => $start_time,
                "duration" => intval($slot_info['duration']),
                "schedule_for" => $user_email,
                "timezone" => "America/Bogota",
                "agenda" => "Esta es una sesion de yoga en linea",
                "settings" => ["registrants_email_notification" => TRUE]
            );

            return json_encode($data);
        }

        private function createMeeting() {
            $body = $this->getRequestBody();
            
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

        private function addRegistrantToMeeting($meeting_id) {
       
            $registrant_url = "https://api.zoom.us/v2/meetings/" . $meeting_id . "/registrants";

            $payer_id = $this->getPayerId();
            $payer_data = MeetingPayer::getPayerData($payer_id);

            $body = (object)array(
                "email" => $payer_data['email'],
                "first_name" => $payer_data['name'],
                "phone" => $payer_data['phone']
            );

            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $registrant_url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_POST, 1);

                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Authorization: Bearer " . $this->token,
                    "Content-Type: application/json"
                ));

                // "{"code":200,"message":"Only available for paid users: q2jGIzNcQoW4kJIsBRhOOQ."}"
                $data = curl_exec($ch);
                curl_close($ch);

                return json_decode($data);

            } catch (Exception $e) {
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            }
        }

        public function proccessMeeting() {
            $meeting_id = $this->getMeetingId();
            $data = $this->createMeeting();

            if (!isset($meeting_id)) {
                $this->message = self::CREATING_ZOOM_MEETING;

                if (isset($data) && !empty($data) && !isset($data->{'code'})) {
                    $this->insertMeetingIdInSlot($data);

                    $this->meeting_data = $data;
                    $this->message = self::SUCCESS_OUTPUT_MESSAGE;
                }
            }

            if (isset($meeting_id) || isset($this->meeting_data)) {
                $this->message = self::UPDATING_ZOOM_MEETING;
                // $registrant = $this->addRegistrantToMeeting($data->{'id'});
                $this->message = self::SUCCESS_OUTPUT_MESSAGE;
            }
        }

        public function getMeetingData() {
            return $this->meeting_data;
        }
    }

    // *** PRUEBAS
    // $meeting = new Meeting('HJNW9FBN92FNBI2', 'JBSQDIJKQIWDBWQIB');
    // $meetingData = $meeting->createMeeting();

    if (isset($_GET['code'])) {
        $api_token = new Token();
        $token_data = $api_token->getData();

        if (isset($token_data) && !empty($token_data)) {
            $token = $token_data[0];
        }

        if (isset($token) && !empty($token)) {
            $allUsers = new Users($token);
            $selectedUserData = $allUsers->getSelectedUserData();
        }
        
        if (isset($selectedUserData) && !empty($selectedUserData)) {
            
            $userId = $selectedUserData->{'id'};
            $userEmail = $selectedUserData->{'email'};

            $meeting = new Meeting($userId, $userEmail, $token);
            $meeting->proccessMeeting();

            $meeting_data = $meeting->getMeetingData();
        }
    }
?>

<!DOCTYPE html>
<html>
    <div>
        Creando la reunión en Zoom...
    </div>

        <ul>
            <?php isset($meeting_data) ? var_dump($meeting_data) : 'ERROR'; ?>
            <!-- <li>Meeting slot state: <?php //echo $slotInfo['state']; ?></li>
            <li>Meeting type: <?php //echo $slotInfo['type']; ?></li> -->
            <!-- <li>Your name: <?php //echo $slotInfo['name']; ?></li>
            <li>Your email: <?php //echo $slotInfo['email']; ?></li> -->
        </ul>
    </div>

    <!-- <script src="request-meeting.js"></script> -->
</html>