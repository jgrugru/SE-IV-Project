<?php
  require('utilities/database.php');
  $db = new DATABASE();

  if(isset($_POST['submitAddCustomer'])){  
    $name = $_POST['name'];
    $id = $_POST['intersection'];
    $intersection = $db->getIntersectionById($id);
    $newCustomer = new CUSTOMER(0, $name, $intersection);
    $db->addCustomer($newCustomer);
    echo "<script>document.location = 'customer.php'</script>";
  }

  if(isset($_POST['submitEditCustomer'])){  
    $name = $_POST['name'];
    $intersection_id = $_POST['intersection'];
    $id = $_POST['id'];
    $intersection = $db->getIntersectionById($intersection_id);
    $customer = $db->getCustomerById($id);
    $customer->updateName($name);
    $customer->updateIntersection($intersection);
    $db->updateCustomer($customer);
    echo "<script>document.location = 'customer.php'</script>";
  }

  if(isset($_POST['submitAddEmployee'])){  
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $type = $_POST['type'];
    $newEmployee = new EMPLOYEE(0, $firstName, $lastName, $type, true);
    $db->addEmployee($newEmployee);
    echo "<script>document.location = 'employee.php'</script>";
  }

  if(isset($_POST['submitAddUser'])){  
    $employeeId = $_POST['employee'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $permission = $_POST['permission'];
    $newUser = new USER($email, $password, $employeeId, $permission);
    $db->addUser($newUser);
    echo "<script>document.location = 'user.php'</script>";
  }

  if(isset($_POST['submitEditEmployee'])){  
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $type = $_POST['type'];
    $active = $_POST['active'];
    $id = $_POST['id'];
    $employee = $db->getEmployeeById($id);
    $employee->updateFirstName($firstName);
    $employee->updateLastName($lastName);
    $employee->updateType($type);
    $employee->updateActive($active);
    $db->updateEmployee($employee);
    echo "<script>document.location = 'employee.php'</script>";
  }

  if(isset($_POST['submitEditCompany'])){  
    $intersection_id = $_POST['intersection'];
    $deliveryBaseCost = $_POST['deliveryBaseCost'];
    $deliveryPerBlockCost = $_POST['deliveryPerBlockCost'];
    $courierBonusTime = $_POST['courierBonusTime'];
    $courierBonusAmount = $_POST['courierBonusAmount'];
    $company = $db->getCompany();
    $intersection = $db->getIntersectionById($intersection_id);
    $company->updateIntersection($intersection);
    $company->updateDeliveryBaseCost($deliveryBaseCost);
    $company->updateDeliveryPerBlockCost($deliveryPerBlockCost);
    $company->updateCourierBonusTime($courierBonusTime);
    $company->updateCourierBonusAmount($courierBonusAmount);
    $db->updateCompany($company);
    echo "<script>document.location = 'index.php'</script>";
  }

  if(isset($_POST['submitEditUser'])){  
    $password = $_POST['password'];
    $permission = $_POST['permission'];
    $employeeId = $_POST['employee'];
    $user = $db->getUserById($employeeId);
    $user->updatePassword($password);
    $user->updatePermission($permission);
    $db->updateUser($user);
    echo "<script>document.location = 'user.php'</script>";
  }

  if(isset($_POST['submitDeleteUser'])){  
    $employeeId = $_POST['employee'];
    $db->deleteUser($employeeId);
    echo "<script>document.location = 'user.php'</script>";
  }

  if(isset($_POST['submitEditTicket'])){  
    $id = $_POST['id'];
    $sender_id = $_POST['fromCustomer'];
    $recipient_id = $_POST['toCustomer'];
    $creator_id = 1;
    $courier_id = $_POST['courier'];
    $date = $_POST['date'];
    $bill_to_id = $_POST['billTo'];
    $assigned_delivery_time = $_POST['estimatedTime'];
    $pickup_time = $_POST['pickUpTime'];
    $delivery_time = $_POST['deliveryTime'];
    $estimated_cost = $_POST['estimatedCost'];
    $cost = $_POST['cost'];
    $status = $_POST['status'];
    $note = $_POST['note'];

    $updateTicket = new TICKET($id,$sender_id, $recipient_id, $creator_id, $courier_id, $date, $bill_to_id, $assigned_delivery_time, $pickup_time, $delivery_time, $estimated_cost, $cost, $status, $note);

    $db->updateTicket($updateTicket);

    echo "<script>document.location = 'index.php'</script>";
  }

  if(isset($_POST['submitDeleteTicket'])){
    $id = $_POST['id'];
    $db->deleteTicket($id);

   echo "<script>document.location = 'index.php'</script>";
  }

  if(isset($_POST['submitOpenInter'])){
    $id = $_POST['openInter'];
    $db->openIntersection($id);
    echo "<script>document.location = 'mapMaintenance.php'</script>";
  }

  if(isset($_POST['submitCloseInter'])){
    $id = $_POST['closeInter'];
    $db->closeIntersection($id);
    echo "<script>document.location = 'mapMaintenance.php'</script>";
  }
  
?>