<?php
    class USER {
        private $email;
        private $employee_id;
        private $permission;
        private $password;

        public function __construct($email, $password, $employee_id, $permission) {
            $this->email = $email;
            $this->password = $password;
            $this->employee_id = $employee_id;
            $this->permission= $permission;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getPassword() {
            return $this->password;
        }

        public function updatePassword($password) {
            $this->password = $password;
        }

        public function getEmployeeId() {
            return $this->employee_id;
        }

        public function getPermission() {
            return $this->permission;
        }

        public function updatePermission($permission) {
            $this->permission = $permission;
        }
    }
?>