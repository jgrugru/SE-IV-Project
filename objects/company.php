<?php
class COMPANY {
        private $name;
        private $intersection;
        private $delivery_base_cost;
        private $delivery_per_block_cost;
        private $courier_bonus_time;
        private $courier_bonus_amount;

        public function __construct($name, $intersection, $delivery_base_cost, $delivery_per_block_cost, $courier_bonus_time, $courier_bonus_amount) {
            $this->name = $name;
            $this->intersection = $intersection;
            $this->delivery_base_cost = $delivery_base_cost;
            $this->delivery_per_block_cost = $delivery_per_block_cost;
            $this->courier_bonus_time = $courier_bonus_time;
            $this->courier_bonus_amount = $courier_bonus_amount;
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

        public function getDeliveryBaseCost() {
            return $this->delivery_base_cost;
        }

        public function updateDeliveryBaseCost($delivery_base_cost) {
            $this->delivery_base_cost = $delivery_base_cost;
        }

        public function getDeliveryPerBlockCost() {
            return $this->delivery_per_block_cost;
        }

        public function updateDeliveryPerBlockCost($delivery_per_block_cost) {
            $this->delivery_per_block_cost = $delivery_per_block_cost;
        }

        public function getCourierBonusTime() {
            return $this->courier_bonus_time;
        }

        public function updateCourierBonusTime($courier_bonus_time) {
            $this->courier_bonus_time = $courier_bonus_time;
        }

        public function getCourierBonusAmount() {
            return $this->courier_bonus_amount;
        }

        public function updateCourierBonusAmount($courier_bonus_amount) {
            $this->courier_bonus_amount = $courier_bonus_amount;
        }
    }
?>