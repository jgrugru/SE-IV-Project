<?php
    class CUSTOMER {
        private $id;
        private $name;
        private $intersection;

        public function __construct($id, $name, $intersection) {
            $this->id = $id;
            $this->name = $name;
            $this->intersection= $intersection;
        }

        public function getId() {
            return $this->id;
        }

        public function getName() {
            return $this->name;
        }

        public function updateName($name) {
            $this->name = $name;
        }

        public function getIntersection() {
            return $this->intersection;
        }

        public function updateIntersection($intersection) {
            $this->intersection = $intersection;
        }
    }
?>