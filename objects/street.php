<?php
    class STREET {
        private $name;
        private $direction;
        private $both_directions;

        public function __construct($name, $direction, $both_directions) {
            $this->name = $name;
            $this->direction = $direction;
            $this->both_directions = $both_directions;
        }

        public function getName() {
            return $this->name;
        }

        public function getDirection() {
            return $this->direction;
        }

        public function isBothDirections() {
            return $this->both_directions;
        }
    }
?>