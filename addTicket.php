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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>ACME: Add Ticket</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="style.css">

  <!-- Okta -->
  <script src="https://ok1static.oktacdn.com/assets/js/sdk/okta-signin-widget/2.6.0/js/okta-sign-in.min.js" type="text/javascript"></script>
  <link href="https://ok1static.oktacdn.com/assets/js/sdk/okta-signin-widget/2.6.0/css/okta-sign-in.min.css" type="text/css" rel="stylesheet"/>
  <link href="https://ok1static.oktacdn.com/assets/js/sdk/okta-signin-widget/2.6.0/css/okta-theme.css" type="text/css" rel="stylesheet"/>

  <!-- Bootstrap -->
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
        <li><a href="maintenance.php"><span class="glyphicon glyphicon-wrench"></span> Maintenance</a></li>
        <li><a href="mapmaintenance.php"><span class="glyphicon glyphicon-map-marker"></span> Map</a></li>
        <li><a href="employee.php"><span class="glyphicon glyphicon-user"></span> Employees</a></li>
        <li><a href="customer.php"><span class="glyphicon glyphicon-list-alt"></span> Customers</a></li>
        <li><a href="reports.html"><span class="glyphicon glyphicon-file"></span> Reports</a></li>
        <li><a href="#" onclick=""><span class="glyphicon glyphicon-new-window"></span> Logout</a></li>
      </ul>
    </div>
  </nav>

  <!-- Form -->
  <div class="container col-sm-12">

    <h3 >Add Ticket</h3>
    <div class="col-sm-1">&nbsp</div>

    <form id="ticketForm" action="ticketEstimations.php" method="post">

      <div class = "col-sm-4">
        <div class="form-group">
          <label for="fromCustomer">From</label>
          <select class="form-control" id="fromCustomer" name="fromCustomer">
            <option></option>
            <?php
                $length = count($customers);
                for($x = 0; $x < $length; $x++){
                  echo "<option value=".$customers[$x]->getId().">".$customers[$x]->getName()."</option>";
                }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="toCustomer">To</label>
          <select class="form-control" id="toCustomer" name="toCustomer">
            <option></option>
            <?php
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

        <div class="form-group">
          <label for="note">Notes:</label>
          <textarea form="ticketForm" class="form-control" rows="4" cols="60" name="note"></textarea>
        </div>

      </div>

      <div class= "col-sm-1">
        <div class="form-group">
          <label for="toCustomer">Bill To</label><br>
          <input type="radio" name="billTo" value="1" checked><br><br><br><br>
          <input type="radio" name="billTo" value="1"><br>
        </div>
      </div>

      <div class ="col-sm-1"></div>

      <div class= "col-sm-4">
        <div class="form-group">
          <label for="pickUpTime">Pick-Up Time:</label>
          <input type="time" id="pickUpTime" name="pickUpTime" min="8:00" max="17:00" value="12:00" required>
        </div>

        <br>

        <div class="form-group">
          <label for="courier">Courier:</label>
          <select class="form-control" name="courier">
          <option></option>
          <?php
            $length = count($couriers);
            for($x = 0; $x < $length; $x++){
              echo "<option value=".$couriers[$x]->getId().">".$couriers[$x]->getFirstName()." ".$couriers[$x]->getLastName()."</option>";
            }
          ?>
          </select>
        </div>

        <br>

      </div>
  </div>

<br>

    <div class ="container col-sm-12">
      <div class="col-sm-5"></div>
      <div class = "col-sm-1">
        <button type="cancel" class="btn btn-primary" onclick="javascript:window.location.href='http://localhost:81/acmecourier/addticket.php';">Cancel</button>
      </div>
      <div class = "col-sm-6">
        <button type="submit" class="btn btn-primary" name="submitAddTicket">Submit</button>
      </div>
    </div>
  </form>

</body>
</html>

