<?php
    class INTERSECTION {
        private $id;
        private $street_x;
        private $street_y;
        private $closed;

        public function __construct($id, $street_x, $street_y, $closed) {
            $this->id = $id;
            $this->street_x = $street_x;
            $this->street_y = $street_y;
            $this->closed = $closed;
        }

        public function getId() {
            return $this->id;
        }

        public function getStreetX() {
            return $this->street_x;
        }

        public function getStreetY() {
            return $this->street_y;
        }

        public function isClosed() {
            return $this->closed;
        }
    }
?>