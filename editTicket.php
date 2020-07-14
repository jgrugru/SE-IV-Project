<?php
  session_start();
  if (!isset($_SESSION['acme_user_id'])){
    echo "<script>document.location = 'login.php'</script>";
  }
  require('utilities/database.php');
  $db = new DATABASE();
  $customers = $db->getCustomers();
  $intersections = $db->getIntersections();
  $couriers = $db->getEmployeesByType("Courier");
  $id = $_GET['id'];
  $ticket = $db->getTicketById($id);
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ACME: Edit Ticket</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
</head>

<body>
   
  <!-- Navbar -->
  <nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
      <a href="index.php"><img src="ACME.png"  style="width:135px;"/></a>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php"><span class="glyphicon glyphicon-tag"></span> Tickets</a></li>
        <li><a href="mapmaintenance.php"><span class="glyphicon glyphicon-map-marker"></span> Map</a></li>
        <li><a href="employee.php"><span class="glyphicon glyphicon-th-list"></span> Employees</a></li>
        <li><a href="customer.php"><span class="glyphicon glyphicon-list-alt"></span> Customers</a></li>
        <?php 
          $user = $db->getUserById($_SESSION['acme_user_id']);
          if ($user->getPermission() == 'Admin') {
            echo '<li><a href="user.php"><span class="glyphicon glyphicon-user"></span> Users</a></li>';
            echo '<li><a href="maintenance.php"><span class="glyphicon glyphicon-wrench"></span> Maintenance</a></li>';
            echo '<li><a href="reports.php"><span class="glyphicon glyphicon-file"></span> Reports</a></li>';
          }
        ?>
        <li><a href="logout.php"><span class="glyphicon glyphicon-new-window"></span> Logout</a></li>
      </ul>
    </div>
  </nav>

  <!-- Form -->
  <div class="container col-sm-12">

    <h3 >Edit Ticket</h3>
    <div class="col-sm-1">&nbsp</div>

    <form action="post.php" method="post">

      <?php
        echo "<input type='hidden' name='id' value='".$id."'>";
        echo "<input type='hidden' name='status' value='".$ticket['ticket']->getStatus()."'>";
        echo "<input type='hidden' name='date' value='".$ticket['ticket']->getDate()."'>";
        echo "<input type='hidden' name='estimatedCost' value='".$ticket['ticket']->getEstimatedCost()."'>";

      ?>
      <div class = "col-sm-4">
        <div class="form-group">

          <!-- To and From Customer -->
          <label for="fromCustomer">From</label>
          <select class="form-control" name="fromCustomer">
          <?php
            echo "<option value=".$ticket['ticket']->getSenderId().">".$ticket['sender']->getName()."</option>";
                $length = count($customers);
                for($x = 0; $x < $length; $x++){
                  echo "<option value=".$customers[$x]->getId().">".$customers[$x]->getName()."</option>";
                  //echo "<option value='".$customers[$x]->getId()."'>".$customers[$x]->getName()."</option>";
                }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="toCustomer">To</label>
          <select class="form-control" name="toCustomer">
            <?php
                echo "<option value=".$ticket['ticket']->getRecipientId().">".$ticket['recipient']->getName()."</option>";
                $length = count($customers);
                for($x = 0; $x < $length; $x++){
                  echo "<option value=".$customers[$x]->getId().">".$customers[$x]->getName()."</option>";
                }
            ?>
          </select>
        </div>
        
        <button type="button" class="btn btn-primary" onclick="javascript:window.location.href='http://localhost:81/acmecourier/addCustomer.php';">Add Customer</button>
        
        <br>
        <br>

        <!-- notes -->
        <div class="form-group">
          <label for="note">Notes:</label>
          <textarea class="form-control" rows="4" cols="60" name="note"><?php
           $note =  $ticket['ticket']->getNote();
           if(!is_null($note)){
             echo $note;
           }
           else{
             echo "";
           }

          ?></textarea>
        </div>

      </div>


      <!-- Radio bill to buttons -->
      <div class= "col-sm-1">
        <div class="form-group">
          <label for="toCustomer">Bill To</label><br>
          <?php
            if($ticket['ticket']->getBillingId() === $ticket['ticket']->getSenderId()){
              echo "<input type='radio' name='billTo' value='".$ticket['ticket']->getSenderId()."' checked>";
              echo "<br><br><br><br>";
              echo "<input type='radio' name='billTo' value='".$ticket['ticket']->getRecipientId()."'>";
            }
            else{
              echo "<input type='radio' name='billTo' value='".$ticket['ticket']->getSenderId()."'>";
              echo "<br><br><br><br>";
              echo "<input type='radio' name='billTo' value='".$ticket['ticket']->getRecipientId()."' checked>";
            }
          ?>
        </div>
      </div>

      <div class ="col-sm-1"></div>

      <!-- Pick up times -->
      <div class= "col-sm-4">
        <div class="form-group">
          <label for="pickUpTime">Pick-Up Time:</label>
          <input type="time" name="pickUpTime" min="8:00" max="17:00" value='<?php echo $ticket['ticket']->getPickupTime(); ?>' required>
        </div>
        <div class="form-group">
          <label for="realPickUpTime">Real Pick-Up Time:</label>
          <input type="time" name="realPickUpTime" min="8:00" max="17:00" value='<?php echo $ticket['ticket']->getPickupTime(); ?>' required>
        </div>

        <br>

      <!-- Courier Selection -->
        <div class="form-group">
          <label for="courier">Courier:</label>
          <select class="form-control" name="courier">
          <?php 
           $courierId = $ticket['ticket']->getCourierId();
           $emp= $db->getEmployeeById($courierId); 
           echo "<option value=".$courierId.">".$emp->getFirstName()." ".$emp->getLastName()."</option>";

            $length = count($couriers);
            for($x = 0; $x < $length; $x++){
              echo "<option value=".$couriers[$x]->getId().">".$couriers[$x]->getFirstName()." ".$couriers[$x]->getLastName()."</option>";
            }
          ?>
          </select>
        </div>
        <br>

      <!-- Delivery Times -->
        <div class="form-group">
          <label for="estimatedTime">Estimated Delivery:</label>
          <input type="time" name="estimatedTime" min="8:00" max="17:00" value='<?php echo $ticket['ticket']->getAssignedDeliveryTime(); ?>'>
        </div>
        <br>

        <div class="form-group">
          <label for="deliveryTime">Delivery Time:</label>
          <input type="time" name="deliveryTime" min="8:00" max="17:00" value='<?php echo $ticket['ticket']->getDeliveryTime(); ?>'>
        </div>
        <br>

      <!-- Cost Text box -->
        <div class="form-group">
          <label for="cost">Cost:</label>
          <input type="text" class="form-control" name="cost" value='<?php echo $ticket['ticket']->getCost(); ?>'>
        </div>
        <br>
      </div>
  </div>

<br>

    <div class ="container col-sm-12">
      <div class="col-sm-5"></div>
      <div class = "col-sm-1">
        <a href="http://localhost:81/acmecourier" class="btn btn-primary">Cancel</a>
      </div>
      <div class = "col-sm-6">
        <button type="submit" class="btn btn-primary" name="submitEditTicket">Update</button>
      </div>
      <div class = "col-sm-6">
        <button type="submit" class="btn btn-primary" name="submitDeleteTicket">Delete</button>
      </div>
    </div>
  </form>

</body>
</html>

