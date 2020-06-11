<?php
    class MeetingUser {
        function __construct($data) {
            $this->slotId = $data['slot-id'];
            $this->userName = $data['payerName'];
            $this->userEmail = $data['payerEmail'];
            $this->userPhone = $data['payerPhone'];
            $this->userDetails = '';

            if (isset($data['payerDetails'])) {
                $this->userDetails = $data['payerDetails'];
            }
        }

        public function insertUser() {
            global $connection;

            $q = "INSERT INTO slot_users (slot_id, name, email, phone, details) ";
            $q .= "VALUES ({$this->slotId}, '{$this->userName}', '{$this->userEmail}', '{$this->userPhone}', '{$this->userDetails}')";

            mysqli_query($connection, $q);

            echo 'creando usuario';
        }
    }

    class DataSlot {
        function __construct($data) {
            $this->data = $data;
        }

        public function getSlotData() {
            require_once('r-schedule.php');

            $body = $_REQUEST;
            $headers = getallheaders();
                    
            $id = $this->data['slot-id'];
            $slot_data = getSelectedSlotData($id);
            $data = json_encode($slot_data);

            echo $data;
        }
    }

    if (isset($_POST)) {
        // hacer la consulta del slot

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