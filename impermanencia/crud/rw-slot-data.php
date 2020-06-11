<?php
    require_once('r-schedule.php');

    class InserMeetingUser {
        function __construct($data) {
            $this->insertUser = $data['slotId'];
            $this->userName = $data['userName'];
            $this->userEmail = $data['userEmail'];
            $this->userPhone = $data['userPhone'];
        }

        public function insertUser() {
            echo 'creando usuario';
        }
    }

    if (isset($_POST)) {
        // hacer la consulta del slot

        if (empty($_POST)) {
            echo 'Error: no slot value';
        } else {
            if (isset($_POST['slot-id'])) {
                $body = $_REQUEST;
                $headers = getallheaders();
                        
                $id = $_POST['slot-id'];
                $slot_data = getSelectedSlotData($id);
                $data = json_encode($slot_data);
        
                echo $data;
            }

            if (isset($_POST['insertUser'])) {
                $insert = new InserMeetingUser($_POST);
                $insert->insertUser();
            }
        }
    }
    
?>