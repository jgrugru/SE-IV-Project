<?php 
    require 'medoo.php';
    require './objects/employee.php';
    require './objects/customer.php';
    require './objects/company.php';
    require './objects/intersection.php';
    require './objects/street.php';
    require './objects/user.php';
    require './objects/ticket.php';
    use Medoo\Medoo;

    class DATABASE {
        private $dsn = 'pgsql:dbname=d6uj63vi3sr5j0;port=5432;host=ec2-54-83-29-34.compute-1.amazonaws.com';
        private $user = 'xlmklrcrxbwrgv';
        private $password = '342ccf292395467bc92bc6ae75f4918c49a0474c8c7a4cadd5a93ab09377a671';
        private $database;

        public function __construct() { 
            $pdo = new PDO($this->dsn, $this->user, $this->password);

            $this->database = new Medoo([
                'pdo' => $pdo,
                'database_type' => 'pgsql',
            ]);
        }

        public function getCompany() {
            $company = $this->database->select("company", "*")[0];
            $intersection = $this->getIntersectionById($company["intersection_id"]);
            return new COMPANY($company["name"], $intersection, $company["delivery_base_cost"], $company["delivery_per_block_cost"], $company["courier_bonus_time"], $company["courier_bonus_amount"]);
        }

        public function updateCompany(COMPANY $company) {
            $this->database->update("company", ["intersection_id" => $company->getIntersection()->getId(), "delivery_base_cost" => $company->getDeliveryBaseCost(), 
                                    "delivery_per_block_cost" => $company->getDeliveryPerBlockCost(), "courier_bonus_time" => $company->getCourierBonusTime(), 
                                    "courier_bonus_amount" => $company->getCourierBonusAmount()], ["name" => $company->getName()]);
        }

        public function getEmployees() {
            $employees = $this->database->select("employee", "*");
            $length = count($employees);
            for($x = 0; $x < $length; $x++){
                $employees[$x] = $this->toEmployee($employees[$x]);
            }
            return $employees;
        }

        public function getEmployeeById(int $id) {
            $employee = $this->database->select("employee", "*", ["id" => $id])[0];
            return $this->toEmployee($employee);
        }

        public function getEmployeesByType(string $type) {
            $employees = $this->database->select("employee", "*", ["type" => $type, "active" => true]);
            $length = count($employees);
            for($x = 0; $x < $length; $x++){
                $employees[$x] = $this->toEmployee($employees[$x]);
            }
            return $employees;
        }

        public function updateEmployee(EMPLOYEE $employee) {
            $this->database->update("employee", ["first_name" => $employee->getFirstName(), "last_name" => $employee->getLastName(), 
                                    "type" => $employee->getType(), "active" => $employee->isActive()], ["id" => $employee->getId()]);
        }

        public function addEmployee(EMPLOYEE $employee) {
            $this->database->insert("employee", ["first_name" => $employee->getFirstName(), "last_name" => $employee->getLastName(), 
                                    "type" => $employee->getType(), "active" => $employee->isActive()]);
        }

        public function deleteEmployee(int $id) {
            $this->database->delete("employee", ["id" => $id]);
        }

        private function toEmployee(array $employee) {
            return new EMPLOYEE($employee["id"], $employee["first_name"], $employee["last_name"], $employee["type"], $employee["active"]);
        }

        public function getCustomers() {
            $customers = $this->database->select("customer", "*");
            $length = count($customers);
            for($x = 0; $x < $length; $x++){
                $intersection = $this->getIntersectionById($customers[$x]["intersection_id"]);
                $customers[$x] = $this->toCustomer($customers[$x], $intersection);
            }
            return $customers;
        }

        public function getCustomerById(int $id) {
            $customer = $this->database->select("customer", "*", ["id" => $id])[0];
            $intersection = $this->getIntersectionById($customer["intersection_id"]);
            return $this->toCustomer($customer, $intersection);
        }

        public function updateCustomer(CUSTOMER $customer) {
            $this->database->update("customer", ["name" => $customer->getName(), "intersection_id" => $customer->getIntersection()->getId()], ["id" => $customer->getId()]);
        }
 
        public function addCustomer(CUSTOMER $customer) {
            $this->database->insert("customer", ["name" => $customer->getName(), "intersection_id" => $customer->getIntersection()->getId()]);
        }

        public function deleteCustomer(int $id) {
            $this->database->delete("customer", ["id" => $id]);
        }

        private function toCustomer(array $customer, INTERSECTION $intersection) {
            return new CUSTOMER($customer["id"], $customer["name"], $intersection);
        }

        public function getIntersections() {
            $intersections = $this->database->select("intersection", "*");
            $length = count($intersections);
            for($x = 0; $x < $length; $x++){
                $street_x = $this->database->select("street", "*", ["name" => $intersections[$x]["street_x"]])[0];
                $street_y = $this->database->select("street", "*", ["name" => $intersections[$x]["street_y"]])[0];
                $intersections[$x] = $this->toIntersection($intersections[$x], $street_x, $street_y);
            }
            return $intersections;
        }

        public function getIntersectionById(int $id) {
            $intersection = $this->database->select("intersection", "*", ["id" => $id])[0];
            $street_x = $this->database->select("street", "*", ["name" => $intersection["street_x"]])[0];
            $street_y = $this->database->select("street", "*", ["name" => $intersection["street_y"]])[0];
            return $this->toIntersection($intersection, $street_x, $street_y);
        }

        public function closeIntersection(int $id) {
            $this->database->update("intersection", ["closed" => true], ["id" => $id]);
        }

        public function openIntersection(int $id) {
            $this->database->update("intersection", ["closed" => false], ["id" => $id]);
        }

        private function toIntersection(array $intersection, array $street_x, array $street_y){
            return new INTERSECTION($intersection["id"], new STREET($street_x["name"], $street_x["direction"], $street_x["both_directions"]), new STREET($street_y["name"], $street_y["direction"], $street_y["both_directions"]), $intersection["closed"]);
        }

        public function getTickets() {
            $tickets = $this->database->select("ticket", "*");
            $length = count($tickets);
            for($x = 0; $x < $length; $x++){
                $sender = $this->database->select("customer", "*", ["id" => $tickets[$x]["sender_id"]])[0];
                $recipient = $this->database->select("customer", "*", ["id" => $tickets[$x]["recipient_id"]])[0];
                $tickets[$x] = $this->toTicket($tickets[$x], $sender, $recipient);
            }
            return $tickets;
        }

        public function getTicketById(int $id) {
            $ticket = $this->database->select("ticket", "*", ["id" => $id])[0];
            $ticket = $this->toTicket($ticket);
            return $ticket;
        }

        public function getTicketsByStatus(string $status) {
            $tickets = $this->database->select("ticket", "*", ["status" => $status]);
            $length = count($tickets);
            for($x = 0; $x < $length; $x++){
                $sender = $this->database->select("customer", "*", ["id" => $tickets[$x]["sender_id"]])[0];
                $recipient = $this->database->select("customer", "*", ["id" => $tickets[$x]["recipient_id"]])[0];
                $tickets[$x] = $this->toTicket($tickets[$x], $sender, $recipient);
            }
            return $tickets;
        }

        public function getTicketsByCustomer(int $sender_id) {
            $tickets = $this->database->select("ticket", "*", ["sender_id" => $sender_id]);
            $length = count($tickets);
            for($x = 0; $x < $length; $x++){
                //$sender = $this->database->select("customer", "*", ["id" => $tickets[$x]["sender_id"]])[0];
                //$recipient = $this->database->select("customer", "*", ["id" => $tickets[$x]["recipient_id"]])[0];
                $tickets[$x] = $this->toTicket($tickets[$x]);//, $sender, $recipient);
            }
            return $tickets;
        }

        public function updateTicket(TICKET $ticket) {
            $this->database->update("ticket", ["sender_id" => $ticket->getSenderId(), "recipient_id" => $ticket->getRecipientId(), "courier_id" => $ticket->getCourierId(),
                                    "bill_to_id" => $ticket->getBillingId(), "assigned_delivery_time" => $ticket->getAssignedDeliveryTime(),
                                    "pickup_time" => $ticket->getPickupTime(), "delivery_time" => $ticket->getDeliveryTime(), "cost" => $ticket->getCost(),
                                    "status" => $ticket->getStatus(), "note"=> $ticket->getNote()], ["id" => $ticket->getId()]);
        }

        public function addTicket(TICKET $ticket) {
            $this->database->insert("ticket", ["sender_id" => $ticket->getSenderId(), "recipient_id" => $ticket->getRecipientId(), "creator_id" => $ticket->getCreatorId(), 
                                    "courier_id" => $ticket->getCourierId(), "date" => $ticket->getDate(), "bill_to_id" => $ticket->getBillingId(), "assigned_delivery_time" => $ticket->getAssignedDeliveryTime(),
                                    "pickup_time" => $ticket->getPickupTime(), "delivery_time" => $ticket->getDeliveryTime(), "estimated_cost" => $ticket->getEstimatedCost(), "cost" => $ticket->getCost(),
                                    "status" => $ticket->getStatus(), "note" => $ticket->getNote()]);
        }

        public function deleteTicket(int $id) {
            $this->database->delete("ticket", ["id" => $id]);
            // if($ticket["status"] == "Awaiting Pickup") {
            //     $this->database->delete("ticket", ["id" => $id]);
            //}
        }

        private function toTicket(array $ticket){
            $sendingCustomer = $this->getCustomerById($ticket['sender_id']);
            $recievingCustomer = $this->getCustomerById($ticket['recipient_id']);

            $ticket = new TICKET($ticket['id'], $ticket['sender_id'], $ticket['recipient_id'], $ticket['creator_id'], $ticket['courier_id'], $ticket['date'],
            $ticket['bill_to_id'], $ticket['assigned_delivery_time'], $ticket['pickup_time'], $ticket['delivery_time'], $ticket['estimated_cost'],
            $ticket['cost'], $ticket['status'], $ticket['note']);

            return array("ticket"=>$ticket, "sender"=>$sendingCustomer, "recipient"=>$recievingCustomer);
        }

        public function getTicketsByBillToIdAndDates(int $bill_to_id, $beginDate, $endDate) {

            $tickets = $this->database->select("ticket", "*",
            [
                "bill_to_id" => $bill_to_id, "date[<>]"=>[$beginDate, $endDate]
            ]);

            $length = count($tickets);
            for($x = 0; $x < $length; $x++){
                $tickets[$x] = $this->toTicket($tickets[$x]);
            }

            return $tickets;
        }

        public function getTicketCountByRecipientAndCourierAndDates(CUSTOMER $customer, int $courier_id, $beginDate, $endDate) {

            $count = $this->database->count("ticket", "*",
            [
                "recipient_id" => $customer->getId(), "date[<>]"=>[$beginDate, $endDate], "courier_id" => $courier_id
            ]);

            return $count;
        }

        public function getOnTimeTicketCountByRecipientAndCourierAndDates(CUSTOMER $customer, int $courier_id, $beginDate, $endDate) {

            $bonusTime = $this->getCompany()->getCourierBonusTime();
            $tickets = $this->database->count("ticket", "*",
            [
                "recipient_id" => $customer->getId(), "date[<>]"=>[$beginDate, $endDate], "courier_id" => $courier_id,
                "delivery_time[<=]" => Medoo::raw("<assigned_delivery_time>+ interval '".$bonusTime." minute'")
            ]);

            return $tickets;
        }
      

        //customer number, name, number of deliviries, percentance of ontime deliveries.
        public function getTicketCountByRecipientAndDates(CUSTOMER $customer, $beginDate, $endDate) {

            $count = $this->database->count("ticket", "*",
            [
                "recipient_id" => $customer->getId(), "date[<>]"=>[$beginDate, $endDate]
            ]);

            return $count;
        }

        public function getOnTimeTicketCountByRecipientAndDates(CUSTOMER $customer, $beginDate, $endDate) {

            $bonusTime = $this->getCompany()->getCourierBonusTime();
            $count = $this->database->count("ticket", "*",
            [
                "recipient_id" => $customer->getId(), "date[<>]"=>[$beginDate, $endDate],
                "delivery_time[<=]" => Medoo::raw("<assigned_delivery_time>+ interval '".$bonusTime." minute'")
            ]);

            return $count;
        }

        public function getUser(string $email) {
            $user = $this->database->select("acme_user", "*", ["email" => $email])[0];
            return $this->toUser($user);
        }

        public function getUserById(int $id) {
            $user = $this->database->select("acme_user", "*", ["employee_id" => $id])[0];
            return $this->toUser($user);
        }

        public function getUsers() {
            $users = $this->database->select("acme_user", "*");
            $length = count($users);
            for($x = 0; $x < $length; $x++){
                $users[$x] = $this->toUser($users[$x]);
            }
            return $users;
        }

        public function addUser(USER $user) {
            $this->database->insert("acme_user", ["email" => $user->getEmail(), "password" => $user->getPassword(), 
                                    "employee_id" => $user->getEmployeeId(), "permission" => $user->getPermission()]);
        }

        public function updateUser(USER $user) {
            $this->database->update("acme_user", ["password" => $user->getPassword(), "permission" => $user->getPermission()], ["email" => $user->getEmail()]);
        }

        public function deleteUser(string $email) {
            $this->database->delete("acme_user", ["email" => $email]);
        }

        private function toUser(array $user){
            return new USER($user["email"], $user['password'], $user['employee_id'], $user['permission']);
        }
    }

?>