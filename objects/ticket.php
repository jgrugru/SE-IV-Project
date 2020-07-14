<?php
    class TICKET {
        private $id;
        private $sender;
        private $recipient;
        private $creator_id;
        private $courier_id;
        private $date;
        private $bill_to_id;
        private $assigned_delivery_time;
        private $pickup_time;
        private $delivery_time;
        private $estimated_cost;
        private $cost;
        private $status;
        private $note;

        public function __construct($id, $sender_id, $recipient_id, $creator_id, $courier_id, $date, $bill_to_id, $assigned_delivery_time, $pickup_time, $delivery_time, $estimated_cost, $cost, $status, $note) {
            $this->id = $id;
            $this->sender_id = $sender_id;
            $this->recipient_id = $recipient_id;
            $this->creator_id = $creator_id;
            $this->courier_id = $courier_id;
            $this->date = $date;
            $this->bill_to_id = $bill_to_id;
            $this->assigned_delivery_time = $assigned_delivery_time;
            $this->pickup_time = $pickup_time;
            $this->delivery_time = $delivery_time;
            $this->estimated_cost = $estimated_cost;
            $this->cost = $cost;
            $this->status = $status;
            $this->note = $note;
        }

        public function getId() {
            return $this->id;
        }

        public function getSenderId() {
            return $this->sender_id;
        }

        public function updateSender($sender){
            $this->sender = $sender;
        }

        public function updateRecipient($recipient){
            $this->recipient = $recipient;
        }

        public function updateSenderId($sender_id) {
            $this->sender_id = $sender_id;
        }

        public function getRecipientId() {
            return $this->recipient_id;
        }

        public function updateRecipientId($recipient_id) {
            $this->recipient_id = $recipient_id;
        }

        public function getCreatorId() {
            return $this->creator_id;
        }

        public function getCourierId() {
            return $this->courier_id;
        }

        public function updateCourierId($courier_id) {
            $this->courier_id = $courier_id;
        }

        public function getDate() {
            return $this->date;
        }

        public function getBillingId() {
            return $this->bill_to_id;
        }

        public function updateBillingId($bill_to_id) {
            $this->bill_to_id = $bill_to_id;
        }

        public function getAssignedDeliveryTime() {
            return $this->assigned_delivery_time;
        }

        public function updateAssignedDeliveryTime($assigned_delivery_time) {
            $this->assigned_delivery_time = $assigned_delivery_time;
        }

        public function getPickupTime() {
            return $this->pickup_time;
        }

        public function updatePickupTime($pickup_time) {
            $this->pickup_time = $pickup_time;
        }

        public function getDeliveryTime() {
            return $this->delivery_time;
        }

        public function updateDeliveryTime($delivery_time) {
            $this->delivery_time = $delivery_time;
        }

        public function getEstimatedCost() {
            return $this->estimated_cost;
        }

        public function getCost() {
            return $this->cost;
        }

        public function updateCost($cost) {
            $this->cost = $cost;
        }

        public function getStatus() {
            return $this->status;
        }

        public function updateStatus($status) {
            $this->status = $status;
        }

        public function getNote() {
            return $this->note;
        }

        public function updateNote($note) {
            $this->note = $note;
        }
    }
?>