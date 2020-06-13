<?php
    function phpMethods($method, $param) {
        global $connection;

        if (phpversion() < 6) {
            switch ($method) {
                case 'query':
                    return mysql_query($param, $connection);
                    break;
                case 'error':
                    return mysql_error();
                    break;
                case 'fetch':
                    return mysql_fetch_array($param);
                    break;
                case 'num-rows':
                    return mysql_num_rows($param);
                    break;
                case 'close':
                    return mysql_close($connection);
                    break;
            }
        } 
        else {
            switch ($method) {
                case 'query':
                    return mysqli_query($connection, $param);
                    break;
                case 'error':
                    return mysqli_error($connection);
                    break;
                case 'fetch':
                    return mysqli_fetch_array($param);
                    break;
                case 'num-rows':
                    return mysqli_num_rows($param);
                    break;
                case 'close':
                    return mysqli_close($connection);
                    break;
            }
        }
    }

    class MeetingPayer {
        function __construct($data) {
            $this->slotId = $data['slot-id'];
            $this->userName = $data['payerName'];
            $this->userEmail = $data['payerEmail'];
            $this->userPhone = $data['payerPhone'];
            $this->userDetails = '';

            $this->payerId = '';

            if (isset($data['payerDetails'])) {
                $this->userDetails = $data['payerDetails'];
            }
        }

        public function insertPayerForSlot() {
            global $connection;

            $q = "INSERT INTO slot_users (slot_id, name, email, phone, details) ";
            $q .= "VALUES ({$this->slotId}, '{$this->userName}', '{$this->userEmail}', '{$this->userPhone}', '{$this->userDetails}')";

            mysqli_query($connection, $q);

            $this->payerId = mysqli_insert_id($connection);
        }

        public function getInsertedPayerId() {
            return $this->payerId;
        }

        public static function getRediectUrl($payerId, $slotId, $meeting_id) {
            global $isTest;
            
            $query_params = [
                "payer-id=" . $payerId,
                "slot-id=" . $slotId,
            ];

            if (isset($meeting_id) && !empty($meeting_id)) {
                array_push($query_params, "meeting-id=" . $meeting_id);
            }

            $back_urls = [
                "success" => "http://www.impermanencia.com/successful-purchase.php?" . join('&', $query_params),
                "failure" => "http://www.impermanencia.com/canceled-purchase.php?" . join('&', $query_params),
                "pending" => "http://www.impermanencia.com/pending-purchase.php?" . join('&', $query_params)
            ];

            $url = $back_urls['success'];
            // $preference->auto_return = "approved";

            // Test options!!!
            $test_back_urls = [
                "success" => "http://localhost/nataliabehaine/dev-nataliabehaine/impermanencia/successful-purchase.html?" . join('&', $query_params),
                "failure" => "http://localhost/nataliabehaine/dev-nataliabehaine/impermanencia/canceled-purchase.html?" . join('&', $query_params),
                "pending" => "http://localhost/nataliabehaine/dev-nataliabehaine/impermanencia/pending-purchase.html?" . join('&', $query_params)
            ];
            
            if ($isTest == TRUE) {
                $url = $test_back_urls['success'];
            }

            return $url;
        }
    }

    class DataSlot {
        function __construct($data) {
            $this->data = $data;
        }

        public static function getSelectedSlotData($id) {
            global $connection;
            $data = [];
    
            $r = phpMethods('query', "SELECT * FROM time_slots WHERE id = " . $id . " LIMIT 1");
    
            while ($h = phpMethods('fetch', $r)) {
                $data += ['state' => $h['state']];
                $data += ['type' => $h['type']];
                $data += ['meeting_id' => $h['meeting_id']];
            }
    
            return $data;
        }

        public function getSlotData() {
            $body = $_REQUEST;
            $headers = getallheaders();
                    
            $id = $this->data['slot-id'];
            $slot_data = self::getSelectedSlotData($id);
            $data = json_encode($slot_data);

            echo $data;
        }

        public static function getSlotPayer() {

        }

        public static function getTimeSlots ($productCode) {
            global $connection;
            $hours = [];
    
            $r = phpMethods('query', "SELECT * FROM time_slots WHERE product_code = " . $productCode . " AND state = 'free'");
    
            while ($h = phpMethods('fetch', $r)) {
                array_push($hours, [
                    'product_code' => $h['product_code'],
                    'type' => $h['type'],
                    'id' => $h['id'],
                    'date' => $h['date'],
                    'time' => $h['time'],
                    'state' => $h['state'],
                    'meeting_id' => $h['meeting_id']
                ]);
            }
    
            return $hours;
        }
    
        public static function getSelectedSlotState($id) {
            global $connection;
            $state = '';
    
            $r = phpMethods('query', "SELECT * FROM time_slots WHERE id = " . $id . " LIMIT 1");
    
            while ($h = phpMethods('fetch', $r)) {
                $state =  $h['state'];
            }
    
            return $state;
        }
    
        public static function blockSlot ($id) {
            global $connection;
    
            $r = phpMethods('query', "UPDATE time_slots SET state = 'blocked' WHERE id =" . $id);
        }
    }

    // *** For request made by client
    if (isset($_POST['rq-type']) && $_POST['rq-type'] == 'client') {
        if (empty($_POST)) {
            echo 'Error: no slot value';
            return;
        }

        if (isset($_POST['slot-id'])) {
            $slot = new DataSlot($_POST);
            $slot->getSlotData();
        }
    }
?>