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

    trait RedirectUrls {
        public $prod_urls = [
            "success" => "http://www.impermanencia.com/successful-purchase.html",
            "failure" => "http://www.impermanencia.com/canceled-purchase.html",
            "pending" => "http://www.impermanencia.com/pending-purchase.html"
        ];

        public $test_urls = [
            "success" => "http://localhost/nataliabehaine/dev-nataliabehaine/impermanencia/successful-purchase.html",
            "failure" => "http://localhost/nataliabehaine/dev-nataliabehaine/impermanencia/canceled-purchase.html",
            "pending" => "http://localhost/nataliabehaine/dev-nataliabehaine/impermanencia/pending-purchase.htm",
        ];
    }

    class MeetingPayer {
        use RedirectUrls;

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

        public static function getPayerData($id) {
            global $connection;
            $data = [];
    
            $r = phpMethods('query', "SELECT * FROM slot_users WHERE id = " . $id . " LIMIT 1");
    
            while ($h = phpMethods('fetch', $r)) {
                $data += ['name' => $h['name']];
                $data += ['email' => $h['email']];
                $data += ['phone' => $h['phone']];
                $data += ['details' => $h['details']];
                $data += ['slot_id' => $h['slot_id']];
            }
    
            return $data;
        }

        public function getRediectUrl($payerId, $slotId, $meeting_id) {
            global $isTest;
            
            $query_params = [
                "payer-id=" . $payerId,
                "slot-id=" . $slotId,
            ];

            if (isset($meeting_id) && !empty($meeting_id)) {
                array_push($query_params, "meeting-id=" . $meeting_id);
            }

            if ($isTest == TRUE) {
                $redirect_urls = $this->test_urls;
            } else {
                $redirect_urls = $this->prod_urls;
            }
            
            $success_url = $redirect_urls['success'] . "?" . join('&', $query_params);
            $failure_url = $redirect_urls['failure'] . "?" . join('&', $query_params);
            $pending_url = $redirect_urls['pending'] . "?" . join('&', $query_params);
            
            $url = $success_url;

            // $preference->auto_return = "approved";
            return $url;
        }

        public function getNoMeetingReservationRedirectUrl() {
            global $isTest;

            if ($isTest == TRUE) {
                $redirect_urls = $this->test_urls;
            } else {
                $redirect_urls = $this->prod_urls;
            }
            
            $success_url = $redirect_urls['success'] . "?no-reservation=true";
            $failure_url = $redirect_urls['failure'] . "?no-reservation=true";
            $pending_url = $redirect_urls['pending'] . "?no-reservation=true";
            
            return $success_url;
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
                $data += ['date' => $h['date']];
                $data += ['time' => $h['time']];
                $data += ['duration' => $h['duration']];
                $data += ['meeting_id' => $h['meeting_id']];
                $data += ['meeting_join_url' => $h['meeting_join_url']];
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

        public static function updateMeetingId($slot_id, $meeting_id, $start_url, $join_url) {
            global $connection;

            $q = "UPDATE time_slots SET meeting_id = " . $meeting_id . ", meeting_start_url = '{$start_url}', meeting_join_url = '{$join_url}' WHERE id = " . $slot_id;

            $r = phpMethods('query', $q);

            if (mysqli_affected_rows($connection) < 1) {
                echo 'Error: ' . mysqli_error($connection);
            }
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