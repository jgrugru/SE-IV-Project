<?php
    class EMPLOYEE {
        private $id;
        private $first_name;
        private $last_name;
        private $type;
        private $active;

        public function __construct($id, $first_name, $last_name, $type, $active) {
            $this->id = $id;
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->type = $type;
            $this->active = $active;
        }

        public function getId() {
            return $this->id;
        }

        public function getFirstName() {
            return $this->first_name;
        }

        public function updateFirstName($first_name) {
            $this->first_name = $first_name;
        }

        public function getLastName() {
            return $this->last_name;
        }

        public function updateLastName($last_name) {
            $this->last_name = $last_name;
        }

        public function getType() {
            return $this->type;
        }

        public function updateType($type) {
            $this->type = $type;
        }

        public function isActive() {
            return $this->active;
        }

        public function updateActive($bool) {
            $this->active = $bool;
        }
    }
?>